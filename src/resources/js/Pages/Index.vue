<script setup>
import { Head } from "@inertiajs/vue3";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/autoplay";
import { Autoplay } from "swiper/modules";

const props = defineProps({
	products: Array,
});
</script>

<template>
	<Head title="商品一覧" />
	<!-- バナーセクション -->
	<div class="mb-8">
		<Swiper
			:modules="[Autoplay]"
			:slides-per-view="1"
			:loop="true"
			:autoplay="{ delay: 3000 }"
			class="w-full h-64"
		>
			<SwiperSlide>
				<img
					:src="'/images/banner1.png'"
					alt="バナー1"
					class="w-100 h-50 object-cover rounded-lg"
				/>
			</SwiperSlide>
			<SwiperSlide>
				<img
					:src="'/images/banner2.png'"
					alt="バナー2"
					class="w-100 h-50 object-cover rounded-lg"
				/>
			</SwiperSlide>
		</Swiper>
	</div>

	<div class="container-fluid my-5">
		<h2 class="fs-5 mb-4">商品を探す</h2>

		<div class="row justify-content-center gx-4 gy-4">
			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<div class="bg-white rounded shadow p-4 text-center h-100">
					<img
						:src="'/images/catfood.jpg'"
						alt="キャットフード"
						class="rounded-circle mx-auto d-block mb-3"
						style="width: 150px; height: 150px; object-fit: cover"
					/>
					<p class="fw-bold">キャットフード</p>
					<p class="m-0"><a href="">もっと見る</a></p>
				</div>
			</div>

			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<div class="bg-white rounded shadow p-4 text-center h-100">
					<img
						:src="'/images/cattower.jpg'"
						alt="キャットタワー"
						class="rounded-circle mx-auto d-block mb-3"
						style="width: 150px; height: 150px; object-fit: cover"
					/>
					<p class="fw-bold">キャットタワー</p>
					<p class="m-0"><a href="">もっと見る</a></p>
				</div>
			</div>

			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<div class="bg-white rounded shadow p-4 text-center h-100">
					<img
						:src="'/images/cattoy.jpg'"
						alt="おもちゃ"
						class="rounded-circle mx-auto d-block mb-3"
						style="width: 150px; height: 150px; object-fit: cover"
					/>
					<p class="fw-bold">おもちゃ</p>
					<p class="m-0"><a href="">もっと見る</a></p>
				</div>
			</div>

			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<div class="bg-white rounded shadow p-4 text-center h-100">
					<img
						:src="'/images/catcage.jpg'"
						alt="ケージ・ケース"
						class="rounded-circle mx-auto d-block mb-3"
						style="width: 150px; height: 150px; object-fit: cover"
					/>
					<p class="fw-bold">ケージ・ケース</p>
					<p class="m-0"><a href="">もっと見る</a></p>
				</div>
			</div>
		</div>
	</div>
</template>
