<script setup lang="ts">
  import { router } from '@inertiajs/vue3';

  const logout = () => {
    router.post('/shop/logout');
  };
</script>

<template>
  <nav class="navbar navbar-expand-lg bg-primary shadow-sm px-3">
    <div class="container-fluid">
      <span class="navbar-brand">MyApp</span>
    </div>

    <form @submit.prevent="logout" method="post">
      <button type="submit" class="nav-item">ログアウト</button>
    </form>
  </nav>
</template>
