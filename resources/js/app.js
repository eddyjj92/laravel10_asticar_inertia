//import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import PrimeVue from 'primevue/config';

createInertiaApp({
    title: title => `Asticar`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin).use(PrimeVue)
            .mount(el)
    },
})
