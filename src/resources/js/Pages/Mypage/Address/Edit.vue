<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';

import type { Address } from '@/types/address';

const page = usePage();
const address = (page.props as { address?: Address }).address ?? {
  zipcode: '',
  prefecture_code: '',
  prefecture: '',
  city: '',
  town: '',
  street: '',
};

const form = useForm({
  zipcode: address.zipcode,
  prefecture_code: address.prefecture_code,
  prefecture: address.prefecture,
  city: address.city,
  town: address.town,
  street: address.street,
});

const errorMessage = ref<string | null>(null);

const fetchAddress = async () => {
  errorMessage.value = null;

  if (!/^\d{7}$/.test(form.zipcode)) return;

  try {
    const response = await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${form.zipcode}`);
    const data = await response.json();

    if (data.results && data.results.length > 0) {
      const result = data.results[0];
      form.prefecture = result.address1;
      form.city = result.address2;
      form.town = result.address3;
      form.prefecture_code = result.prefcode;
    } else {
      errorMessage.value = '住所が見つかりません。';
    }
  } catch (error) {
    errorMessage.value = '住所の取得中にエラーが発生しました。';
  }
};

const submit = () => {
  form.patch(route('mypage.address.update'), {
    preserveScroll: true,
  });
};
</script>

<template>
  <div class="container py-5">
    <h2 class="mb-4">お届け先の変更</h2>

    <form @submit.prevent="submit">
      <!-- 郵便番号 -->
      <div class="mb-3">
        <label for="zipcode" class="form-label">郵便番号</label>
        <input
          type="text"
          id="zipcode"
          class="form-control"
          v-model="form.zipcode"
          maxlength="7"
          @blur="fetchAddress"
        />
        <InputError :message="form.errors.zipcode" class="text-danger mt-1" />
      </div>

      <!-- 都道府県 -->
      <div class="mb-3">
        <label for="prefecture" class="form-label">都道府県</label>
        <input
          type="text"
          id="prefecture"
          class="form-control"
          v-model="form.prefecture"
        />
        <InputError :message="form.errors.prefecture" class="text-danger mt-1" />
      </div>

      <!-- 市区町村 -->
      <div class="mb-3">
        <label for="city" class="form-label">市区町村</label>
        <input
          type="text"
          id="city"
          class="form-control"
          v-model="form.city"
        />
        <InputError :message="form.errors.city" class="text-danger mt-1" />
      </div>

      <!-- 町域 -->
      <div class="mb-3">
        <label for="town" class="form-label">町域</label>
        <input
          type="text"
          id="town"
          class="form-control"
          v-model="form.town"
        />
        <InputError :message="form.errors.town" class="text-danger mt-1" />
      </div>

      <!-- 番地・建物名など -->
      <div class="mb-3">
        <label for="street" class="form-label">番地・建物名など</label>
        <input
          type="text"
          id="street"
          class="form-control"
          v-model="form.street"
        />
        <InputError :message="form.errors.street" class="text-danger mt-1" />
      </div>

      <!-- 送信ボタン -->
      <div class="mt-4 text-center">
        <button
          type="submit"
          class="btn btn-primary"
          :disabled="form.processing"
        >
          保存する
        </button>
      </div>
    </form>
  </div>
</template>
