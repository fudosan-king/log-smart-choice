require('./bootstrap');

import axios from 'axios';
import VueRouter from 'vue-router';
import Vue from 'vue';
import store from './store/index';
import router from './router/index';
import globalHelper from './globalHelper';
import Vuelidate from 'vuelidate';
import customerMododul from './store/modules/customer.js';


// Set Vue router
Vue.router = router;
Vue.use(VueRouter);
Vue.use(globalHelper);
Vue.use(Vuelidate);

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
        this.$store.registerModule('customer', customerMododul);
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
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.go(0);
                });
            }
        },
    },
    mounted() {
        // mili seconds
        setInterval(this.getRefreshTokenApi, 15000000);
    }
});