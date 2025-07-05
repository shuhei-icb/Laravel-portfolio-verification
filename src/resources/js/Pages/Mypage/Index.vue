<script setup>
import { usePage, Link } from "@inertiajs/vue3";

const page = usePage();
const user = page.props.auth?.user || {};
const address = page.props.address || {};
</script>

<style scoped>
.edit-btn {
	transition: background-color 0.3s, color 0.3s;
	cursor: pointer;
}

.edit-btn:hover {
	background-color: #0d6efd;
}

.edit-btn:hover {
	color: #fff !important;
}
</style>

<template>
	<div class="container-fluid">
		<div class="row mb-5">
			<div class="col-md-10 offset-md-1">
				<div class="shadow">
					<div class="d-flex p-3">
						<div class="p-3">
							<img
								:src="user.avatar_url || '/images/no_user.png'"
								alt="ユーザー画像"
								class="rounded-circle me-3"
								style="width: 80px; height: 80px; object-fit: cover"
							/>
						</div>
						<div class="my-auto">
							<p class="fs-5 fw-bold m-0 pt-3">{{ user.name }}</p>
							<p>{{ user.email }}</p>
						</div>
						<div class="my-auto ms-auto">
							<Link
								:href="route('mypage.profile.edit')"
								class="text-decoration-none text-dark"
							>
								<div class="border rounded-pill px-5 py-2 edit-btn">編集</div>
							</Link>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-10 offset-md-1">
				<div class="shadow">
					<div class="d-flex p-3">
						<div class="">
							<h2 class="fs-5 fw-bold">お届け先</h2>
							<p class="m-0">{{ address.zipcode }}</p>
							<p>
								{{ address.prefecture }}
								{{ address.city }}
								{{ address.town }}
								{{ address.street }}
							</p>
						</div>
						<div class="my-auto ms-auto">
							<Link
								:href="route('mypage.address.edit')"
								class="text-decoration-none text-dark"
							>
								<div class="border rounded-pill px-5 py-2 edit-btn">編集</div>
							</Link>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-10 offset-md-1">
				<div class="shadow">
					<h2 class="fs-5 p-2 fw-bold">注文履歴</h2>
					<div class="p-2">
						<div>商品A</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
