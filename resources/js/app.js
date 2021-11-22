require('./bootstrap');
const _ = require('lodash');

// Import modules...
import { createApp, h } from 'vue';
import store from './store';
import ElementPlus from 'element-plus/lib';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import PrimeVue from "primevue/config";
import { InertiaProgress } from '@inertiajs/progress';

const el = document.getElementById('app');

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route } })
    .use(ElementPlus)
    .use(InertiaPlugin)
    .use(PrimeVue)
    .use(store)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });
