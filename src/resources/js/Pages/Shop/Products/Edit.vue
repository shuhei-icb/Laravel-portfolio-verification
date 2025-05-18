<script setup>
import { ref, onMounted } from "vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";

const props = defineProps({
	product: Object,
});

const form = useForm({
  name: props.product.name,
  price: parseInt(props.product.price, 10),
  stock: props.product.stock,
  description: props.product.description,
  images: [],
  captions: [],
  sort_orders: [],
	image_ids: [],
});

// 画像編集用データ
const imageData = ref([]);

// 初期画像を設定
onMounted(() => {
  if (props.product.images && props.product.images.length) {
    imageData.value = props.product.images.map((img, index) => ({
      id: img.id,
      file: null,
      caption: img.caption || "",
      sortOrder: img.sort_order ?? index,
      preview: `/storage/${img.image_path}`,
      existing: true,
    }));
  }
});

const handleFileChange = (e, index) => {
  const file = e.target.files[0];
  imageData.value[index].file = file;
  imageData.value[index].preview = file ? URL.createObjectURL(file) : null;
  imageData.value[index].existing = false; // 新しい画像に置き換えた扱いに
};

const addImageField = () => {
  imageData.value.push({
    file: null,
    caption: "",
    sortOrder: imageData.value.length,
    preview: null,
    existing: false,
  });
};

const removeImageField = (index) => {
  imageData.value.splice(index, 1);
};

const submit = () => {
  const formData = new FormData();

  imageData.value.forEach((img, index) => {
    // 新規 or 置き換え画像がある場合は追加
    if (img.file) {
      formData.append(`images[${index}]`, img.file);
    }

    // キャプション・並び順・ID は常に送る
    formData.append(`captions[${index}]`, img.caption || '');
    formData.append(`sort_orders[${index}]`, img.sortOrder ?? index);
    formData.append(`image_ids[${index}]`, img.id ?? '');
  });

  // その他商品データ
  formData.append('name', form.name);
  formData.append('price', parseInt(form.price, 10));
  formData.append('stock', parseInt(form.stock, 10));
  formData.append('description', form.description || '');

  router.post(`/shop/products/${props.product.id}`, formData, {
    forceFormData: true,
    preserveScroll: true,
    onError: (errors) => {
      console.error(errors);
    },
  });
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
                更新
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
