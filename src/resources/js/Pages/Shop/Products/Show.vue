<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import { formatPrice } from "@/utils/format";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Thumbs, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/thumbs";

const props = defineProps({
	product: Object,
});

// サムネイルSwiperのインスタンス参照用
const thumbsSwiper = ref(null);
</script>

<style scoped>
.mySwiper {
	width: 100%;
	max-width: 600px;
	margin: 0 auto;
}
.slide-img {
	width: 100%;
	max-height: 400px;
	object-fit: contain;
}
.thumb-img {
	width: 100%;
	height: 80px;
	object-fit: cover;
	cursor: pointer;
	opacity: 0.6;
	border: 2px solid transparent;
	transition: opacity 0.2s, border 0.2s;
}
.swiper-slide-thumb-active .thumb-img {
	opacity: 1;
	border-color: #007bff;
}
</style>

<template>
	<Head :title="product.name" />
	<div class="container py-4">
		<div class="row mb-4">
			<div class="col-md-6">
				<swiper
					v-if="product.images && product.images.length"
					:modules="[Thumbs, Pagination]"
					:thumbs="{ swiper: thumbsSwiper }"
					:slides-per-view="1"
					pagination
					class="mySwiper mb-3"
				>
					<swiper-slide v-for="(img, index) in product.images" :key="index">
						<img
							:src="`/storage/${img.image_path}`"
							:alt="img.caption || '商品画像'"
							class="slide-img"
						/>
					</swiper-slide>
				</swiper>

				<!-- サムネイル -->
				<swiper
					v-if="product.images.length > 1"
					:modules="[Thumbs]"
					@swiper="(swiper) => (thumbsSwiper = swiper)"
					:slides-per-view="Math.min(product.images.length, 4)"
					space-between="10"
					free-mode
					watch-slides-progress
					class="mySwiper"
				>
					<swiper-slide
						v-for="(img, index) in product.images"
						:key="'thumb-' + index"
					>
						<img
							:src="`/storage/${img.image_path}`"
							alt="サムネイル画像"
							class="thumb-img"
						/>
					</swiper-slide>
				</swiper>
				<p v-else>画像はありません。</p>
			</div>

			<div class="col-md-6">
				<h1 class="fs-3 mb-4">{{ product.name }}</h1>
				<p class="text-end">
					<span class="fs-3">{{ formatPrice(product.price) }}</span>
					<span>(税込)</span>
				</p>
				<p>{{ product.description || "説明はありません。" }}</p>
			</div>
		</div>

		<div class="text-end">
			<Link
				:href="`/shop/products/${product.id}/edit`"
				class="btn btn-outline-primary me-2"
			>
				編集
			</Link>
			<Link href="/shop/products" class="btn btn-secondary">戻る</Link>
		</div>
	</div>
</template>
