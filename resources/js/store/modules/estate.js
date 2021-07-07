import axios from 'axios';
import { reject } from 'lodash';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);

const state = {};

const getters = {};

const actions = {
    addWishList({}, data) {
        return new Promise((relove, reject) => {
            const auth = this.auth;
            axios
                .post('/wishlist', data, {
                    headers: {
                        'content-type': 'application/json',
                        AuthorizationBearer: 'Bearer '+ data.accessToken,
                    },
                    auth: auth
                }).then(resp => {
                    relove(resp)
                }).catch(error => {
                    reject(error);
                });
        });
    },

    getEstateList({}, data) {
        return new Promise((relove, reject) => {
            const auth = this.auth;
            axios({ url: '/list', method: 'POST', data: data, auth: auth }).then(resp => {
                if (resp.data['data']) {
                    let data = {
                        'data':resp.data['data'],
                        'lastedEstate': resp.data['lasted_estate'],
                        'total': resp.data.total
                    }
                    relove(data);
                }
            }).catch(error => {
                reject(error);
            });
        })
    },

    getEstatesNear({}, data) {
        return new Promise((relove, reject) => {
            const auth = this.auth;
            axios({ url: '/estate/near', method: 'POST', data: data, auth: auth }).then(resp => {
                if (resp.data['data']) {
                    relove(resp.data['data']);
                }
            }).catch(error => {
                reject(error);
            });
        })
    },

    getEstate({}, data) {
        return new Promise((relsove, reject) => {
            axios({ url: '/detail', method: 'POST', data: data }).then(resp => {
                relsove(resp);
            }).catch(error => {
                reject(error);
            });
        })
    }

};

const mutations = {};

export default {
    state,
    getters,
    actions,
    mutations
};