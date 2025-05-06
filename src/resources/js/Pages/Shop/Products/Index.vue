<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { VueGoodTable } from "vue-good-table-next";
import { formatPrice } from "@/utils/format";

const props = defineProps({
	products: Array,
});

const destroy = (id) => {
	if (confirm("本当に削除しますか？")) {
		router.delete(`/shop/products/${id}`);
	}
};

const columns = [
	{ label: "ID", field: "id", sortable: true, tdClass: " align-middle" },
	{
		label: "商品名",
		field: "name",
		sortable: true,
		tdClass: "w-50 align-middle",
	},
	{
		label: "価格",
		field: "price",
		type: "number",
		sortable: true,
		tdClass: " align-middle",
	},
	{
		label: "在庫数",
		field: "stock",
		type: "number",
		sortable: true,
		tdClass: " align-middle",
	},
	{ field: "edit", sortable: false, tdClass: "text-center", width: "40px" },
	{ field: "destroy", sortable: false, tdClass: "text-center", width: "40px" },
];
</script>

<template>
	<Head title="商品一覧" />
	<div class="container-fluid">
		<h1 class="mb-4 fs-4">商品一覧</h1>
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<Link class="btn btn-outline-primary" href="/shop/products/create"
					>商品を追加</Link
				>
				<div class="card-body">
					<vue-good-table
						:columns="columns"
						:rows="products"
						:search-options="{ enabled: true }"
						:pagination-options="{ enabled: true, perPage: 10 }"
					>
						<template #table-row="props">
							<span v-if="props.column.field === 'price'">
								{{ formatPrice(props.row.price) }}
							</span>
							<span v-else-if="props.column.field === 'edit'">
								<Link
									:href="`/shop/products/${props.row.id}/edit`"
									class="btn"
									title="編集"
								>
									<i class="bi bi-pencil-square"></i>
								</Link>
							</span>
							<span v-else-if="props.column.field === 'destroy'">
								<button class="btn" @click="destroy(props.row.id)" title="削除">
									<i class="bi bi-trash"></i>
								</button>
							</span>
							<span v-else>
								{{ props.formattedRow[props.column.field] }}
							</span>
						</template>
					</vue-good-table>
				</div>
			</div>
		</div>
	</div>
</template>
