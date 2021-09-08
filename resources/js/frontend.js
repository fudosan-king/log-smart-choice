require('./bootstrap');

import axios from 'axios';
import VueRouter from 'vue-router';
import Vue from 'vue';
import store from './store/index';
import router from './router/index';
import globalHelper from './globalHelper';
import Vuelidate from 'vuelidate';
import customerModule from './store/modules/customer.js';
// import gAuth from './config/googleAuth';
// import FBAuth from './config/facebookAuth';

// const gAuthOption = {
//     clientId: process.env.MIX_GOOGLE_CLIENT_ID,
//     scope: "profile email",
//     jsSrc: "https://apis.google.com/js/api.js",
// };

// const fbAuthOption = {
//     appID: process.env.MIX_FACEBOOK_APP_ID,
//     jsID: "facebook-jssdk",
//     jsSrc: "https://connect.facebook.net/en_US/sdk.js",
//     version: "v10.0",
// };


// Set Vue router
Vue.router = router;
Vue.use(VueRouter);
Vue.use(globalHelper);
Vue.use(Vuelidate);
// Vue.use(gAuth, gAuthOption);
// Vue.use(FBAuth, fbAuthOption); 
window.LSMEvent = new Vue();

axios.defaults.withCredentials = true;
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;

new Vue({
    el: '#app',
    router,
    store,
    components: {
        Index: () => import('./Index.vue'),
    },
    created() {
        this.$store.registerModule('customer', customerModule);
        this.getRefreshTokenApi();
    },
    beforeDestroy() {
        this.$store.unregisterModule('customer');
    },
    methods: {
        getRefreshTokenApi: function () {
            let isLoggedIn = this.$store.getters.isLoggedIn;
            if (isLoggedIn) {
                this.$store.dispatch('customerInfo').then(resp => {
                }).catch(() => {
                    this.$setCookie('accessToken', '', 1);
                    this.$setCookie('accessToken3d', '', 1);
                    this.$setCookie('refreshToken', '', 1);
                    this.$setCookie('clientId', '', 1);
                    this.$setCookie('clientSecret', '', 1);
                    this.$setCookie('userName', '', 1);
                    this.$setCookie('announcement_count', '', 1);
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.go(0);
                });
            }
        },
    },
    mounted() {
        // mili seconds
        // setInterval(this.getRefreshTokenApi, 15000000);
    }
});