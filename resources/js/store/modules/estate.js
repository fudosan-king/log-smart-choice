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
                })
        });
    },

    getEstateList({}, data) {
        return new Promise((relove, reject) => {
            const auth = this.auth;
            axios({ url: '/list', method: 'POST', data: data, auth: auth }).then(resp => {
                this.existedEstate = true;
                if (resp.data['data']) {
                    relove(resp.data['data']);
                }
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