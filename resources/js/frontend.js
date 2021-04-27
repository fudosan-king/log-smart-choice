require('./bootstrap');

import 'es6-promise/auto';
import axios from 'axios';
import VueRouter from 'vue-router';
import Vue from 'vue';
import Index from './Index.vue';
import store from './store/index';
import router from './router/index';
import globalHelper from './globalHelper';
import Vuelidate from 'vuelidate';
import gAuth from './config/googleAuth';
import Lazyload from 'vue-lazyload';
import FBAuth from './config/facebookAuth';

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);
Vue.use(globalHelper);
Vue.use(Vuelidate);

const gAuthOption = {
    clientId: process.env.MIX_GOOGLE_CLIENT_ID,
    scope: "profile email",
    jsSrc: "https://apis.google.com/js/api.js",
};

Vue.use(gAuth, gAuthOption);

const fbAuthOption = {
    appID: process.env.MIX_FACEBOOK_APP_ID,
    jsID: "facebook-jssdk",
    jsSrc: "https://connect.facebook.net/en_US/sdk.js",
    version: "v10.0",
}

Vue.use(FBAuth, fbAuthOption);


Vue.use(Lazyload, {
    preLoad: 1.3,
    error: 'images/no-image.png',
    loading: 'images/loading.gif',
    attempt: 1,
});

axios.defaults.withCredentials = true;
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;

new Vue({
    el: '#app',
    router,
    store,
    components: { Index },
    created() {
        this.getRefreshTokenApi();
    },
    methods: {
        getRefreshTokenApi: function () {
            let isLoggedIn = this.$store.getters.isLoggedIn;
            if (isLoggedIn) {
                this.$store.dispatch('customerInfo').then(resp => {
                }).catch(error => {
                    this.$setCookie('accessToken', '', 1);
                    this.$setCookie('accessToken3d', '', 1);
                    this.$setCookie('refreshToken', '', 1);
                    this.$setCookie('clientId', '', 1);
                    this.$setCookie('clientSecret', '', 1);
                    this.$setCookie('userName', '', 1);
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.go(0);
                });
            }
        },
    },
    mounted() {
        // milisecond
        setInterval(this.getRefreshTokenApi, 15000000);
    }
});