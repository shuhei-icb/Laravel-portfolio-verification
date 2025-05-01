<script setup lang="ts">
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
	<div class="container">
		<div class="col-md-6 offset-md-3 mt-5">
			<div class="text-center">
				<Link href="/">
					<ApplicationLogo class="h-25 w-25" />
				</Link>
			</div>
			<div class="card">
				<div class="card-body">
					<slot />
				</div>
			</div>
		</div>
	</div>
	
</template>
