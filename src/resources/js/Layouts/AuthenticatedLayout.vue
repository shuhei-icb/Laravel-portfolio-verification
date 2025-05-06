<script setup lang="ts">
import Header from "@/Components/organisms/Header.vue";
import Sidebar from "@/Components/organisms/Sidebar.vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const user = page.props.auth?.user;
</script>

<template>
	<Header />
	<div class="d-flex" style="height: calc(100vh - 56px)">
		<Sidebar :user="user" />
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
