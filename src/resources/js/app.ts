import '../css/app.css';
import './bootstrap';
import '../scss/bootstrap.scss';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'vue-good-table-next/dist/vue-good-table-next.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h, DefineComponent } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        const pages = import.meta.glob<DefineComponent>('./Pages/**/*.vue');
        const page = (await pages[`./Pages/${name}.vue`]()).default;

        // すべてのページに AuthenticatedLayout を適用
        page.layout ??= AuthenticatedLayout;

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
