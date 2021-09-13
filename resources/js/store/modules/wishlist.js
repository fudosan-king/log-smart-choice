import axios from 'axios';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);

const state = {};

const getters = {};

const actions = {

    getWishlist({}, data) {
        return new Promise((relove, reject) => {
            const auth = this.auth;
            let accessToken = `Bearer ${Vue.prototype.$getLocalStorage('accessToken')}`;
            axios({ url: '/wishlist/list', method: 'POST', data: data, headers: {
                'Content-type': 'application/json',
                'AuthorizationBearer': accessToken
            }})
            .then(resp => {
                if (resp.data['data']) {
                    let data = {
                        'data':resp.data['data']
                    }
                    relove(data);
                }
            }).catch(error => {
                reject(error);
            });
        })
    },

};

const mutations = {};

export default {
    state,
    getters,
    actions,
    mutations
};