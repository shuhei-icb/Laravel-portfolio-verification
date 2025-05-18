<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ref, watchEffect } from 'vue';

  defineProps<{
    user: {
      name: string;
      avatar?: string;
    };
  }>();

  const page = usePage();
  const currentPath = ref(page.url);

  watchEffect(() => {
    currentPath.value = page.url;
  });
</script>

<template>
  <div class="d-flex flex-column" style="min-width: 250px;">
    <div class="flex-grow-1 overflow-auto p-3">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <Link
            href="/shop/dashboard"
            class="nav-link"
            :class="{ active: currentPath === '/shop/dashboard' }"
          >
            ダッシュボード
          </Link>
        </li>
        <li class="nav-item">
          <Link
            href="/shop/products"
            class="nav-link"
            :class="{ active: currentPath.startsWith('/shop/products') }"
          >
            商品管理
          </Link>
        </li>
        <li class="nav-item">
          <Link
            href="/shop/orders"
            class="nav-link"
            :class="{ active: currentPath.startsWith('/shop/orders') }"
          >
            注文管理
          </Link>
        </li>
        <li class="nav-item">
          <Link
            href="/shop/sales"
            class="nav-link"
            :class="{ active: currentPath.startsWith('/shop/sales') }"
          >
            売上管理
          </Link>
        </li>
        <li class="nav-item">
          <Link
            href="/shop/settings"
            class="nav-link"
            :class="{ active: currentPath.startsWith('/shop/settings') }"
          >
            設定
          </Link>
        </li>
      </ul>
    </div>

    <div class="p-3 border-top d-flex align-items-center">
      <img
        :src="user.avatar || 'https://via.placeholder.com/40'"
        alt="User Icon"
        class="rounded-circle me-2"
        width="40"
        height="40"
      />
      <div>
        <div class="fw-bold small">{{ user.name }}</div>
        <div class="text-muted small">ログイン中</div>
      </div>
    </div>
  </div>
</template>
