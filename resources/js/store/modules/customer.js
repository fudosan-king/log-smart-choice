import axios from 'axios';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);

const state = {};

const getters = {};

const actions = {
    customerInfo() {
        return new Promise((resolve, reject) => {
            let accessToken = Vue.prototype.$getLocalStorage('accessToken');
            const auth = this.auth;
            let err = '';
            if (accessToken) {
                axios({
                    url: '/customer',
                    method: 'POST',
                    data: {},
                    headers: {
                        'content-type': 'application/json',
                        'AuthorizationBearer': 'Bearer ' + accessToken,
                    },
                    auth: auth,
                })
                    .then(resp => {
                        Vue.prototype.$setLocalStorage('userName', resp.data.data.name);
                        Vue.prototype.$setLocalStorage('announcement_count', resp.data.data.announcement_count);
                        resolve(resp.data.data);
                    })
                    .catch(err => {
                        reject(err);
                    });
            } else {
                err = "Missing token";
                reject(err);
            }
        });
    },
    changePassword({ }, data) {
        return new Promise((resolve, reject) => {
            let accessToken = Vue.prototype.$getLocalStorage('accessToken');
            const auth = this.auth;
            axios({
                url: '/confirm-password',
                method: 'PUT',
                data,
                headers: {
                    'content-type': 'application/json',
                    'AuthorizationBearer': `Bearer ${accessToken}`,
                }, auth: auth,
            }).then(resp => {
                resolve(resp.data);
            }).catch(err => {
                reject(err);
            });
        });
    },
    updateInformation({ }, data) {
        return new Promise((resolve, reject) => {
            let accessToken = Vue.prototype.$getLocalStorage('accessToken');
            const auth = this.auth;
            axios({
                url: '/customer',
                method: 'PUT',
                data,
                headers: {
                    'content-type': 'application/json',
                    'AuthorizationBearer': `Bearer ${accessToken}`,
                }, auth: auth,
            }).then(resp => {
                resolve(resp.data);
            }).catch(err => {
                reject(err);
            });
        });
    },

    updateAnnouncement({}, data) {
        return new Promise((resolve, reject) => {
            let accessToken = Vue.prototype.$getLocalStorage('accessToken');
            const auth = this.auth;
            axios({
                url: '/customer/announcement-condition',
                method: 'PUT',
                data,
                headers: {
                    'content-type': 'application/json',
                    'AuthorizationBearer': `Bearer ${accessToken}`,
                }, auth: auth,
            }).then(resp => {
                resolve(resp.data);
            }).catch(err => {
                reject(err);
            });
        });
    },

    resetPassword({}, data) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            axios({
                url: '/reset-password/'+data.hash,
                method: 'POST',
                data,
                headers: {
                    'content-type': 'application/json',
                }, auth: auth,
            }).then(resp => {
                resolve(resp.data);
            }).catch(err => {
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