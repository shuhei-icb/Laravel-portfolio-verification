<script setup lang="ts">
  defineProps<{
    user: {
      name: string;
      avatar?: string;
    };
  }>();
</script>

<template>
  <div class="d-flex flex-column" style="width: 250px;">
    <div class="flex-grow-1 overflow-auto p-3">
      <ul class="nav nav-pills flex-column">
        <li><router-link class="nav-link active" to="/">商品管理</router-link></li>
        <li><router-link class="nav-link text-dark" to="/dashboard">注文管理</router-link></li>
        <li><router-link class="nav-link text-dark" to="/dashboard">売上管理</router-link></li>
        <li><router-link class="nav-link text-dark" to="/settings">設定</router-link></li>
      </ul>
    </div>

    <div class="p-3 border-top d-flex align-items-center">
      <img src="https://via.placeholder.com/40" alt="User Icon" class="rounded-circle me-2" />
      <div>
        <div class="fw-bold small">{{ user.name }}</div>
        <div class="text-muted small">ログイン中</div>
      </div>
    </div>
  </div>
</template>
