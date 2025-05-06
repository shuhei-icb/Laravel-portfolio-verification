<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
	product: Object,
});

const form = useForm({
	name: props.product.name,
	price: Math.floor(Number(props.product.price)),
	stock: props.product.stock,
	description: props.product.description,
});

const submit = () => {
	form.put(`/shop/products/${props.product.id}`);
};
</script>

<template>
	<Head title="商品編集" />
	<div class="container-fluid">
		<h1 class="mb-4 fs-4">商品編集</h1>
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<form @submit.prevent="submit">
					<div class="d-flex mb-3 pb-3 border-bottom">
						<div class="p-4 w-25">
							<label class="form-label">商品名</label>
						</div>
						<div class="p-4 w-50">
							<input type="text" class="form-control" v-model="form.name" />
						</div>
					</div>
					<div class="d-flex mb-3 pb-3 border-bottom">
						<div class="p-4 w-25">
							<label class="form-label">価格</label>
						</div>
						<div class="p-4 d-flex align-items-center">
							<input type="number" step="1" class="form-control" v-model="form.price" />
							<span class="ms-2">円</span>
						</div>
					</div>
					<div class="d-flex mb-3 pb-3 border-bottom">
						<div class="p-4 w-25">
							<label class="form-label">在庫</label>
						</div>
						<div class="p-4 d-flex align-items-center">
							<input type="number" class="form-control" v-model="form.stock" />
							<span class="ms-2">個</span>
						</div>
					</div>
					<div class="d-flex mb-3 pb-3 border-bottom">
						<div class="p-4 w-25">
							<label class="form-label">説明</label>
						</div>
						<div class="p-4 w-50">
							<textarea class="form-control" v-model="form.description" />
						</div>
					</div>
					<div class="d-flex justify-content-evenly w-50 mx-auto my-5">
						<div class="w-100 text-center p-2">
							<Link href="/shop/products" class="btn btn-secondary w-100 py-3"
								>キャンセル</Link
							>
						</div>
						<div class="w-100 text-center p-2">
							<button type="submit" class="btn btn-primary w-100 py-3">
								登録
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>
