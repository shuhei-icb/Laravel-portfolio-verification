<script setup lang="ts">
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";

defineProps<{
	mustVerifyEmail?: boolean;
	status?: string;
}>();
</script>

<template>
	<Head title="Profile" />
	<div class="container-fluid">
		<div class="row mb-5">
			<div class="col-md-10 offset-md-1">
				<div class="p-4 shadow">
					<UpdateProfileInformationForm
						:must-verify-email="mustVerifyEmail"
						:status="status"
						class="max-w-xl"
					/>
				</div>
			</div>
		</div>

		<div class="row mb-5">
			<div class="col-md-10 offset-md-1">
				<div class="p-4 shadow">
					<UpdatePasswordForm class="max-w-xl" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-10 offset-md-1">
				<div class="p-4 shadow">
					<DeleteUserForm class="max-w-xl" />
				</div>
			</div>
		</div>
	</div>
</template>
