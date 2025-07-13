import "../css/app.css";
import "./bootstrap";
import "../scss/bootstrap.scss";
import "bootstrap-icons/font/bootstrap-icons.css";
import "vue-good-table-next/dist/vue-good-table-next.css";

import { createInertiaApp } from "@inertiajs/vue3";
import { createApp, h, DefineComponent } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GuestLayout from "./Layouts/GuestLayout.vue";
import MypageLayout from "./Layouts/MypageLayout.vue";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
	title: (title) => `${title} - ${appName}`,
	resolve: async (name) => {
		const pages = import.meta.glob<DefineComponent>("./Pages/**/*.vue");
		// const path = `./Pages/${name}.vue`;

		const page = (await pages[`./Pages/${name}.vue`]()).default;

		// 現在のパスによってレイアウトを切り替える
		// const currentPath = window.location.pathname;

		if (name.startsWith("Shop/")) {
			page.layout ??= AuthenticatedLayout;
		} else if (name.startsWith("Mypage/")) {
			page.layout ??= MypageLayout;
		} else {
			page.layout ??= GuestLayout;
		}
	
		return page;
	},
	setup({ el, App, props, plugin }) {
		createApp({ render: () => h(App, props) })
			.use(plugin)
			.use(ZiggyVue)
			.mount(el);
	},
	progress: {
		color: "#4B5563",
	},
});
