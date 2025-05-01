<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Header from "@/Components/organisms/Header.vue";
import Sidebar from "@/Components/organisms/Sidebar.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const user = page.props.auth?.user;
const message = computed(() => page.props.flash?.message);

</script>

<template>
	<Head title="Shop | Dashboard" />

	<Header />
	<div class="d-flex" style="height: calc(100vh - 56px);">
		<Sidebar :user="user" />
		<div class="flex-grow-1 overflow-auto p-4 " style="background-color: #f8f9fc;">
			<AuthenticatedLayout>
				<div class="container-fluid p-0">
					<div v-if="message" class="alert alert-success my-3 text-center">{{ message }}</div>
				</div>
			</AuthenticatedLayout>
		</div>
	</div>
</template>
