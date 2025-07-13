<script setup lang="ts">
import ShopHeader from "@/Components/organisms/ShopHeader.vue";
import Sidebar from "@/Components/organisms/Sidebar.vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const user = page.props.auth?.user;
</script>

<template>
	<ShopHeader />
	<div class="d-flex" style="height: calc(100vh - 56px)">
		<Sidebar v-if="user" :user="user" />
		<div
			class="flex-grow-1 overflow-auto p-4"
			style="background-color: #f8f9fc"
		>
			<!-- Page Content -->
			<main>
				<slot />
			</main>
		</div>
	</div>
</template>
