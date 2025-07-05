<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
	current_password: "",
	password: "",
	password_confirmation: "",
});

const updatePassword = () => {
	form.put(route("mypage.password.update"), {
		preserveScroll: true,
		onSuccess: () => {
			form.reset();
		},
		onError: () => {
			if (form.errors.password) {
				form.reset("password", "password_confirmation");
				passwordInput.value?.focus();
			}
			if (form.errors.current_password) {
				form.reset("current_password");
				currentPasswordInput.value?.focus();
			}
		},
	});
};
</script>

<template>
	<section>
		<header class="mb-4">
			<h2 class="h5 fw-bold">パスワード変更</h2>
		</header>

		<form @submit.prevent="updatePassword">
			<div class="mb-3">
				<label for="current_password" class="form-label"
					>現在のパスワード</label
				>
				<input
					id="current_password"
					ref="currentPasswordInput"
					v-model="form.current_password"
					type="password"
					class="form-control"
					:class="{ 'is-invalid': form.errors.current_password }"
					autocomplete="current-password"
				/>
				<div v-if="form.errors.current_password" class="invalid-feedback">
					{{ form.errors.current_password }}
				</div>
			</div>

			<div class="mb-3">
				<label for="password" class="form-label">新しいパスワード</label>
				<input
					id="password"
					ref="passwordInput"
					v-model="form.password"
					type="password"
					class="form-control"
					:class="{ 'is-invalid': form.errors.password }"
					autocomplete="new-password"
				/>
				<div v-if="form.errors.password" class="invalid-feedback">
					{{ form.errors.password }}
				</div>
			</div>

			<div class="mb-3">
				<label for="password_confirmation" class="form-label"
					>パスワード確認用</label
				>
				<input
					id="password_confirmation"
					v-model="form.password_confirmation"
					type="password"
					class="form-control"
					:class="{ 'is-invalid': form.errors.password_confirmation }"
					autocomplete="new-password"
				/>
				<div v-if="form.errors.password_confirmation" class="invalid-feedback">
					{{ form.errors.password_confirmation }}
				</div>
			</div>

			<div class="d-flex align-items-center gap-3">
				<button
					type="submit"
					class="btn btn-primary"
					:disabled="form.processing"
				>
					Save
				</button>

				<Transition enter-active-class="fade" leave-active-class="fade">
					<p v-if="form.recentlySuccessful" class="text-muted small mb-0">
						Saved.
					</p>
				</Transition>
			</div>
		</form>
	</section>
</template>
