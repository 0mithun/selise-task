import './bootstrap';
import { createApp } from 'vue'
import { createPinia } from "pinia";
import App from './App.vue'
import router from './router/index';
import VueClickAway from "vue3-click-away";


import VCalendar from 'v-calendar';
import 'v-calendar/dist/style.css';

import mitt from 'mitt';
const emitter = mitt();

const pinia = createPinia();
const app = createApp(App)
    .use(pinia)
    .use(VueClickAway)
    .use(VCalendar, {})
    .provide("emitter", emitter)


    app.config.globalProperties.emitter = emitter;
    app.use(router)
        .mount("#app")

