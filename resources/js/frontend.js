require('./bootstrap');

import axios from 'axios';
import VueRouter from 'vue-router';
import Vue from 'vue';
import store from './store/index';
import router from './router/index';
import Vuelidate from 'vuelidate';
import customerModule from './store/modules/customer.js';
import gAuth from './config/googleAuth';
import FBAuth from './config/facebookAuth';
import VueMeta from 'vue-meta';

const gAuthOption = {
    clientId: process.env.MIX_GOOGLE_CLIENT_ID,
    scope: 'profile email',
    jsSrc: 'https://apis.google.com/js/api.js'
};

const fbAuthOption = {
    appID: process.env.MIX_FACEBOOK_APP_ID,
    jsID: 'facebook-jssdk',
    jsSrc: 'https://connect.facebook.net/en_US/sdk.js',
    version: 'v10.0'
};

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);
Vue.use(Vuelidate);
Vue.use(VueMeta);
Vue.use(gAuth, gAuthOption);
Vue.use(FBAuth, fbAuthOption);
window.LSMEvent = new Vue();

axios.defaults.withCredentials = true;
axios.defaults.timeout = 2500;
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
axios.interceptors.response.use(undefined, function (error) {
    if (error && error.response) {
        if (error.response.status === 401) {
            let urlRedirect = window.location.pathname;
            return router.push({ path: '/login', query: { redirect: urlRedirect } });
        } else {
            return Promise.reject(error);
        }
    }
});

new Vue({
    el: '#app',
    router,
    store,
    components: {
        Index: () => import('./Index.vue')
    },
    created() {
        this.$store.registerModule('customer', customerModule);
    },
    beforeDestroy() {
        this.$store.unregisterModule('customer');
    }
});
