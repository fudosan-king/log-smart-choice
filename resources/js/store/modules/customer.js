import axios from 'axios';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);

const state = {};

const getters = {};

const actions = {
    customerInfo() {
        return new Promise((relove, reject) => {
            let accessToken = this._vm.$getCookie('accessToken');
            const auth = this.auth;
            axios({
                url: '/customer',
                method: 'POST',
                data: {},
                headers: {
                    'content-type': 'application/json',
                    'AuthorizationBearer': `Bearer ${accessToken}`,
                },
                auth: auth,
            })
                .then(resp => {
                    this.customer = resp.data.data;
                    this._vm.$setCookie('userName', resp.data.data.name, 1);
                    relove(this.customer);
                })
                .catch(err => { 
                    reject(err);
                });
        });
    }
};

const mutations = {};

export default {
    state,
    getters,
    actions,
    mutations
};