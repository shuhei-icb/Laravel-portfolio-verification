<script setup lang="ts">
import Header from "@/Components/organisms/Header.vue";
import Footer from "@/Components/organisms/Footer.vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const user = page.props.auth?.user;
</script>

<template>
	<Header />
	<div class="d-flex" style="height: calc(100vh - 56px)">
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
	<Footer />
</template>
