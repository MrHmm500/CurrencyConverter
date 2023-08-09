import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import UserRouter from "./components/UserRouter.vue";
import Router from "./components/GuestRouter.vue";
import VueRouter from "vue-router";

import axios from 'axios';

window.axios = axios;

const app = createApp({
    router: VueRouter,
    components: {
        Router,
        UserRouter
    }
});

app.mount("#app");
