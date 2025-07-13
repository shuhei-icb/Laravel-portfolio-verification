<script setup lang="ts">
import { router, usePage, Link } from "@inertiajs/vue3";
import { ref } from "vue";

const page = usePage();
const isAuthenticated = !!page.props.auth?.user;

const logout = () => {
	router.post("/logout");
};

// 検索処理
const keyword = ref("");
const search = () => {
	router.get("/products", { search: keyword.value });
};
</script>

<template>
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
		<div class="container">
			<!-- ブランド -->
			<a class="navbar-brand fw-bold text-primary" href="/">MyShop</a>

			<button
				class="navbar-toggler"
				type="button"
				data-bs-toggle="collapse"
				data-bs-target="#navbarNav"
			>
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarNav">
				<!-- 左側ナビ -->
				<ul class="navbar-nav me-auto">
					<li class="nav-item">
						<a class="nav-link" href="/products">商品一覧</a>
					</li>
				</ul>

				<!-- 検索フォーム（中央寄せ・幅広） -->
				<form
					class="d-flex mx-auto w-50"
					role="search"
					@submit.prevent="search"
				>
					<input
						class="form-control"
						type="search"
						placeholder="商品を検索..."
						v-model="keyword"
					/>
					<button class="btn btn-outline-secondary ms-2" type="submit">
						<i class="bi bi-search"></i>
					</button>
				</form>

				<ul class="navbar-nav">
					<li class="nav-item">
						<Link href="/mypage" class="nav-link">マイページ</Link>
					</li>
				</ul>

				<!-- カートアイコン -->
				<a href="/cart" class="nav-link ms-3">
					<i class="bi bi-cart"></i>
				</a>

				<!-- 認証状態に応じて表示 -->
				<template v-if="isAuthenticated">
					<form @submit.prevent="logout" method="post" class="ms-2">
						<button class="nav-link btn btn-link p-0" type="submit">
							ログアウト
						</button>
					</form>
				</template>
				<template v-else>
					<a class="nav-link ms-2" href="/login">ログイン</a>
				</template>
			</div>
		</div>
	</nav>
</template>
