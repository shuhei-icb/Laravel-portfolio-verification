<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
	password: "",
});

const confirmUserDeletion = () => {
	confirmingUserDeletion.value = true;
	nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
	form.delete(route("profile.destroy"), {
		preserveScroll: true,
		onSuccess: () => closeModal(),
		onError: () => passwordInput.value?.focus(),
		onFinish: () => {
			form.reset();
		},
	});
};

const closeModal = () => {
	confirmingUserDeletion.value = false;
	form.clearErrors();
	form.reset();
};
</script>

<template>
	<section>
		<header class="mb-3">
			<h2 class="h5 fw-bold">アカウントの削除</h2>
		</header>

		<button type="button" class="btn btn-danger" @click="confirmUserDeletion">
			アカウントを削除する
		</button>

		<!-- Modal -->
		<div
			class="modal fade"
			tabindex="-1"
			:class="{ show: confirmingUserDeletion }"
			:style="{ display: confirmingUserDeletion ? 'block' : 'none' }"
			role="dialog"
			aria-modal="true"
		>
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">
							本当にアカウントを削除してよろしいですか？
						</h5>
						<button
							type="button"
							class="btn-close"
							@click="closeModal"
							aria-label="Close"
						></button>
					</div>
					<div class="modal-body">
						<p>
							アカウントを削除すると、すべてのリソースとデータが完全に削除されます。アカウントを完全に削除することを確認するため、パスワードを入力してください。
						</p>

						<div class="mb-3">
							<label for="password" class="form-label">Password</label>
							<input
								id="password"
								ref="passwordInput"
								v-model="form.password"
								type="password"
								class="form-control"
								:class="{ 'is-invalid': form.errors.password }"
								placeholder="Password"
								@keyup.enter="deleteUser"
							/>
							<div v-if="form.errors.password" class="invalid-feedback">
								{{ form.errors.password }}
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" @click="closeModal">
							キャンセル
						</button>
						<button
							type="button"
							class="btn btn-danger"
							:disabled="form.processing"
							:class="{ disabled: form.processing }"
							@click="deleteUser"
						>
							削除
						</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Backdrop -->
		<div
			v-if="confirmingUserDeletion"
			class="modal-backdrop fade show"
			@click="closeModal"
		></div>
	</section>
</template>
