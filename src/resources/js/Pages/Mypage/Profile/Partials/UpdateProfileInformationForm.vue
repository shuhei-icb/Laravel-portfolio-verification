<script setup lang="ts">
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps<{
	mustVerifyEmail?: Boolean;
	status?: String;
}>();

const user = usePage().props.auth.user;

const form = useForm({
	name: user.name,
	email: user.email,
});
</script>

<template>
	<section>
		<header class="mb-4">
			<h2 class="h5 fw-bold">会員情報</h2>
		</header>

		<form @submit.prevent="form.patch(route('mypage.profile.update'))">
			<div class="mb-3">
				<label for="name" class="form-label">名前</label>
				<input
					id="name"
					type="text"
					class="form-control"
					:class="{ 'is-invalid': form.errors.name }"
					v-model="form.name"
					required
					autofocus
					autocomplete="name"
				/>
				<div v-if="form.errors.name" class="invalid-feedback">
					{{ form.errors.name }}
				</div>
			</div>

			<div class="mb-3">
				<label for="email" class="form-label">メールアドレス</label>
				<input
					id="email"
					type="email"
					class="form-control"
					:class="{ 'is-invalid': form.errors.email }"
					v-model="form.email"
					required
					autocomplete="username"
				/>
				<div v-if="form.errors.email" class="invalid-feedback">
					{{ form.errors.email }}
				</div>
			</div>

			<div
				v-if="mustVerifyEmail && user.email_verified_at === null"
				class="mb-3"
			>
				<p class="text-danger small mb-2">Your email address is unverified.</p>
				<Link
					:href="route('verification.send')"
					method="post"
					as="button"
					class="btn btn-outline-secondary btn-sm mb-2"
				>
					Click here to re-send the verification email.
				</Link>
				<div
					v-show="status === 'verification-link-sent'"
					class="text-success small"
				>
					A new verification link has been sent to your email address.
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
