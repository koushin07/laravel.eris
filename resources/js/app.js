import './bootstrap';
import '../css/app.css';
import '../css/styles.css';
import '../css/landing.css';
import "vue-toastification/dist/index.css";

import { createApp, h } from 'vue';
import Toast from "vue-toastification";
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import "vue-select/dist/vue-select.css";
import { library } from '@fortawesome/fontawesome-svg-core'

import { fas } from '@fortawesome/free-solid-svg-icons'
import { far }from '@fortawesome/free-regular-svg-icons'
import { dom } from "@fortawesome/fontawesome-svg-core";
import {Chart} from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import vSelect from "vue-select";


Chart.register(ChartDataLabels);


library.add(fas, far)
dom.watch();

const options = {
    transition: "Vue-Toastification__fade",
    maxToasts: 12,
    newestOnTop: true
  };


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
createInertiaApp({
    title: (title) => `${title} - EPRRIS`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
       
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(Toast, options)
            
            .use(ZiggyVue, Ziggy)
            .component("v-select", vSelect)
            .component('InertiaHead', Head)
            .component('InertiaLink', Link)
            .mount(el);
          
    },
});

InertiaProgress.init({ color: '#73ACF9' });
