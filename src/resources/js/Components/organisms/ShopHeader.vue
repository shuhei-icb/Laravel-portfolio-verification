<script setup lang="ts">
import { router, usePage, Link } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth?.user;

const logout = () => {
  router.post('/shop/logout');
};
</script>

<template>
  <nav class="navbar navbar-expand-lg bg-primary shadow-sm px-3">
    <div class="container-fluid">
      <span class="navbar-brand text-white">MyApp</span>

      <div class="ms-auto">
        <template v-if="user">
          <form @submit.prevent="logout" method="post" class="d-inline">
            <button type="submit" class="btn btn-outline-light">ログアウト</button>
          </form>
        </template>
        <template v-else>
          <Link href="/shop/login" class="btn btn-outline-light">ログイン</Link>
        </template>
      </div>
    </div>
  </nav>
</template>
