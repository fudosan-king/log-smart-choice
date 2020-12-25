require('./bootstrap');

import 'es6-promise/auto';
import axios from 'axios';
import VueRouter from 'vue-router';
import Vue from 'vue';
import Index from './Index';
import store from './store/index';
import router from './router/index';

window.Vue = require('vue');

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);

axios.defaults.withCredentials = true;
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;

axios.interceptors.response.use(undefined, function (error) {
    if (error) {
        const originalRequest = error.config;
        if (error.response.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true;
            store.dispatch("LogOut");
            return router.push("/login");
        }
    }
});

new Vue({
    el: '#app',
    router,
    store,
    components: { Index },
});
