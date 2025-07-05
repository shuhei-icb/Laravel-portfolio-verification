<script setup lang="ts">
import Header from "@/Components/organisms/Header.vue";
import Footer from "@/Components/organisms/Footer.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { computed, ref, watchEffect } from "vue";

const page = usePage();
const flashMessage = computed(() => page.props.flash?.message ?? null);
const showFlash = ref(false);

watchEffect(() => {
	if (flashMessage.value) {
		showFlash.value = true;
		setTimeout(() => {
			showFlash.value = false;
		}, 3000); // 3秒表示
	}
});
</script>

<template>
	<Header />

	<div class="d-flex min-vh-100">
		<!-- Sidebar -->
		<aside class="d-none d-md-block bg-light p-4" style="width: 250px">
			<nav class="nav flex-column">
				<Link href="/shop/mypage/orders" class="nav-link">注文履歴</Link>
				<Link href="/shop/mypage/favorites" class="nav-link">お気に入り</Link>
				<Link href="/mypage/profile" class="nav-link">会員情報の変更</Link>
				<Link href="/mypage/address" class="nav-link">お届け先</Link>
			</nav>
		</aside>

		<!-- Main content -->
		<main class="flex-fill p-4">
			<div
				v-if="showFlash && flashMessage"
				class="alert alert-success text-center m-0 rounded-0"
			>
				{{ flashMessage }}
			</div>
			<slot />
		</main>
	</div>
	<Footer />
</template>
