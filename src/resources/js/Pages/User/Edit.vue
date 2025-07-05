<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3'
import { User } from '@/types';

// ページデータからユーザー情報を取得（auth.user に格納されていると仮定）
const page = usePage();
const user = page.props.auth?.user as User

const form = useForm({
  name: user.name,
  email: user.email,
})

const submit = () => {
  form.put(route('profile.update'), {
    onSuccess: () => {
      alert('プロフィールを更新しました')
    },
  })
}
</script>

<template>
  <div class="container py-5" style="max-width: 600px;">
    <h2 class="mb-4">ユーザー情報編集</h2>

    <form @submit.prevent="submit">
      <!-- 名前 -->
      <div class="mb-3">
        <label for="name" class="form-label">名前</label>
        <input
          id="name"
          v-model="form.name"
          type="text"
          class="form-control"
          :class="{ 'is-invalid': form.errors.name }"
        />
        <div class="invalid-feedback" v-if="form.errors.name">{{ form.errors.name }}</div>
      </div>

      <!-- メール -->
      <div class="mb-3">
        <label for="email" class="form-label">メールアドレス</label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          class="form-control"
          :class="{ 'is-invalid': form.errors.email }"
        />
        <div class="invalid-feedback" v-if="form.errors.email">{{ form.errors.email }}</div>
      </div>

      <!-- 送信ボタン -->
      <button class="btn btn-success w-100" type="submit" :disabled="form.processing">
        {{ form.processing ? '更新中...' : '更新' }}
      </button>
    </form>
  </div>
</template>
