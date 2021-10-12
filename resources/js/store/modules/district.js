import axios from 'axios';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);

const state = {};

const getters = {};

const actions = {
    getDistrict() {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            axios({
                url: '/district/list',
                method: 'POST',
                data: {},
                headers: {
                    'content-type': 'application/json',
                },
                auth: auth,
            })
                .then(resp => {
                    resolve(resp.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    getCustomerDistrict() {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            axios({
                url: '/district/customer/list',
                method: 'POST',
                data: {},
                headers: {
                    'content-type': 'application/json'
                },
                auth: auth,
            })
                .then(resp => {
                    resolve(resp.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
};


const mutations = {};

export default {
    state,
    getters,
    actions,
    mutations
};