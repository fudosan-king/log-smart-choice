require('./bootstrap');

import 'es6-promise/auto';
import axios from 'axios';
import VueRouter from 'vue-router';
import Vue from 'vue';
import Index from './Index.vue';
import store from './store/index';
import router from './router/index';

window.Vue = require('vue');

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);

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
            localStorage.getItem('token');
            let isLoggedIn = this.$store.getters.isLoggedIn;
            if (isLoggedIn) {
                this.$store.dispatch('refreshToken').then(resp => { }).catch(error => {
                    localStorage.removeItem('access_token');
                    localStorage.removeItem('refresh_token');
                    delete axios.defaults.headers.common['Authorization'];
                });
            }
        }
    },
    mounted() {
        setInterval(this.getRefreshTokenApi, 15000);
    }
});
