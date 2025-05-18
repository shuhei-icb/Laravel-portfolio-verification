<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
	name: "",
	price: 0,
	stock: 0,
	description: "",
	images: [],
	captions: [],
	sort_orders: [],
});

const imageData = ref([]);

const addImageField = () => {
	imageData.value.push({
		file: null,
		caption: "",
		sortOrder: imageData.value.length,
		preview: null,
	});
};

const handleFileChange = (e, index) => {
	const file = e.target.files[0];
	imageData.value[index].file = file;
	imageData.value[index].preview = file ? URL.createObjectURL(file) : null;
};

const removeImageField = (index) => {
	imageData.value.splice(index, 1);
	imageData.value.forEach((img, i) => {
		img.sortOrder = i;
	});
};

const submit = () => {
	form.images = imageData.value.map((img) => img.file);
	form.captions = imageData.value.map((img) => img.caption);
	form.sort_orders = imageData.value.map((img, i) =>
		img.sortOrder !== undefined ? img.sortOrder : i
	);

	form.post("/shop/products", {
		forceFormData: true,
		preserveScroll: true,
		onStart: () => (form.processing = true),
		onFinish: () => (form.processing = false),
	});
};
</script>

<template>
	<Head title="商品登録" />
	<div class="container-fluid">
		<h1 class="mb-4 fs-4">商品登録</h1>
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<form @submit.prevent="submit">
					<div class="d-flex mb-3 pb-3 border-bottom">
						<div class="p-4 w-25">
							<label class="form-label">商品画像</label>
						</div>
						<div class="p-4 w-50">
							<button
								type="button"
								class="btn btn-outline-primary"
								@click="addImageField"
							>
								＋ 画像を追加
							</button>
						</div>
					</div>
					<div class="row">
						<div
							v-for="(img, index) in imageData"
							:key="index"
							class="col-md-2 mb-3 p-3 border rounded position-relative"
						>
							<button
								type="button"
								class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
								@click="removeImageField(index)"
							>
								削除
							</button>
							<div class="mb-2">
								<label class="form-label">画像 {{ index + 1 }}</label>
								<input
									type="file"
									class="form-control"
									@change="(e) => handleFileChange(e, index)"
								/>
							</div>
							<div v-if="img.preview" class="mb-2">
								<img
									:src="img.preview"
									alt="プレビュー画像"
									class="img-thumbnail img-fluid w-100"
									style="max-width: 200px; object-fit: contain"
								/>
							</div>
							<div class="mb-2">
								<label class="form-label">キャプション</label>
								<input type="text" v-model="img.caption" class="form-control" />
							</div>
							<div class="mb-2">
								<label class="form-label">並び順</label>
								<input
									type="number"
									v-model="img.sortOrder"
									class="form-control"
								/>
							</div>
						</div>
					</div>

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
							<input type="number" class="form-control" v-model="form.price" />
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
