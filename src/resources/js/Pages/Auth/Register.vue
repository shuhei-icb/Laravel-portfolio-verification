<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const form = useForm({
	name: "",
	email: "",
	password: "",
	password_confirmation: "",
	zip: "",
	prefecture: "",
	city: "",
	address: "",
});

const fetchAddress = async () => {
	if (!form.zip || form.zip.length < 7) return;

	try {
		const response = await fetch(
			`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${form.zip}`
		);
		const data = await response.json();

		if (data.results && data.results.length > 0) {
			const result = data.results[0];
			form.prefecture = result.address1;
			form.city = result.address2 + result.address3;
		}
	} catch (error) {
		console.error("住所の自動補完に失敗しました:", error);
	}
};
</script>

<template>
	<div class="container mt-5">
		<h2 class="mb-4">新規ユーザー登録</h2>

		<form @submit.prevent="form.post(route('register'))">
			<div class="mb-3">
				<label for="name" class="form-label">名前</label>
				<input
					v-model="form.name"
					type="text"
					id="name"
					class="form-control"
					:class="{ 'is-invalid': form.errors.name }"
				/>
				<div class="invalid-feedback">{{ form.errors.name }}</div>
			</div>

			<div class="mb-3">
				<label for="email" class="form-label">メールアドレス</label>
				<input
					v-model="form.email"
					type="email"
					id="email"
					class="form-control"
					:class="{ 'is-invalid': form.errors.email }"
				/>
				<div class="invalid-feedback">{{ form.errors.email }}</div>
			</div>

			<div class="mb-3">
				<label for="zip" class="form-label">郵便番号</label>
				<input
					v-model="form.zip"
					type="text"
					id="zip"
					class="form-control"
					maxlength="7"
					@keyup="fetchAddress"
					:class="{ 'is-invalid': form.errors.zip }"
				/>
				<div class="invalid-feedback">{{ form.errors.zip }}</div>
			</div>

			<div class="mb-3">
				<label for="prefecture" class="form-label">都道府県</label>
				<input
					v-model="form.prefecture"
					type="text"
					id="prefecture"
					class="form-control"
					readonly
				/>
			</div>

			<div class="mb-3">
				<label for="city" class="form-label">市区町村・町名</label>
				<input
					v-model="form.city"
					type="text"
					id="city"
					class="form-control"
					readonly
				/>
			</div>

			<div class="mb-3">
				<label for="address" class="form-label">番地・建物名</label>
				<input
					v-model="form.address"
					type="text"
					id="address"
					class="form-control"
					:class="{ 'is-invalid': form.errors.address }"
				/>
				<div class="invalid-feedback">{{ form.errors.address }}</div>
			</div>

			<div class="mb-3">
				<label for="password" class="form-label">パスワード</label>
				<input
					v-model="form.password"
					type="password"
					id="password"
					class="form-control"
					:class="{ 'is-invalid': form.errors.password }"
				/>
				<div class="invalid-feedback">{{ form.errors.password }}</div>
			</div>

			<div class="mb-3">
				<label for="password_confirmation" class="form-label"
					>パスワード確認</label
				>
				<input
					v-model="form.password_confirmation"
					type="password"
					id="password_confirmation"
					class="form-control"
					:class="{ 'is-invalid': form.errors.password_confirmation }"
				/>
				<div class="invalid-feedback">
					{{ form.errors.password_confirmation }}
				</div>
			</div>

			<button type="submit" class="btn btn-primary" :disabled="form.processing">
				登録
			</button>
		</form>
	</div>
</template>
