<script setup lang="ts">
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineOptions({
  layout: GuestLayout,
});

defineProps<{
	canResetPassword?: boolean;
	status?: string;
}>();

const form = useForm({
	email: "",
	password: "",
	remember: false,
});

const submit = () => {
	form.post(route("shop.login"), {
		onFinish: () => {
			form.reset("password");
		},
	});
};
</script>

<template>
		<Head title="Shop | Log in" />

		<div v-if="status" class="mb-4 text-success">
			{{ status }}
		</div>

		<form @submit.prevent="submit">
			<div>
				<InputLabel for="email" value="Email" />

				<TextInput
					id="email"
					type="email"
					class="mt-1"
					v-model="form.email"
					required
					autofocus
					autocomplete="email"
				/>

				<InputError class="mt-2" :message="form.errors.email" />
			</div>

			<div class="mt-4">
				<InputLabel for="password" value="Password" />

				<TextInput
					id="password"
					type="password"
					class="mt-1"
					v-model="form.password"
					required
					autocomplete="current-password"
				/>

				<InputError class="mt-2" :message="form.errors.password" />
			</div>

			<div class="mt-4">
				<label class="flex items-center">
					<Checkbox name="remember" v-model:checked="form.remember" />
					<span class="ms-2 text-secondary">Remember me</span>
				</label>
			</div>

			<div>
				<Link
					v-if="canResetPassword"
					:href="route('password.request')"
				>
					Forgot your password?
				</Link>
			</div>

			<div class="mt-3 text-center">
				<PrimaryButton
					class="ms-4"
					:class="{ 'opacity-25': form.processing }"
					:disabled="form.processing"
				>
					Log in
				</PrimaryButton>
			</div>
		</form>
</template>
