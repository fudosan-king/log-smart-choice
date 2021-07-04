import axios from 'axios';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);

const state = {};

const getters = {};

const actions = {

    getAnnouncementList({ }, data) {
        return new Promise((relove, reject) => {
            const auth = this.auth;
            let accessToken = `Bearer ${this._vm.$getCookie('accessToken')}`;
            axios({
                url: '/announcement/list', method: 'POST', data: data, headers: {
                    'Content-type': 'application/json',
                    'AuthorizationBearer': accessToken
                }, auth: auth
            })
                .then(resp => {
                    if (resp.data['data']) {
                        let data = {
                            'data': resp.data['data']
                        }
                        relove(data);
                    }
                }).catch(error => {
                    reject(error);
                });
        })
    },

    deleteAnnoutcement({ }, data) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            let accessToken = `Bearer ${this._vm.$getCookie('accessToken')}`;
            axios({
                url: '/announcement', method: 'DELETE', data: data, headers: {
                    'Content-type': 'application/json',
                    'AuthorizationBearer': accessToken
                }, auth: auth
            })
                .then(resp => {
                    resolve(resp);
                }).catch(error => {
                    reject(error);
                });
        });
    },

    readAnnouncement({ }, data) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            let accessToken = `Bearer ${this._vm.$getCookie('accessToken')}`;
            axios({
                url: '/announcement', method: 'PUT', data: data, headers: {
                    'Content-type': 'application/json',
                    'AuthorizationBearer': accessToken
                }, auth: auth
            })
                .then(resp => {
                    resolve(resp);
                }).catch(error => {
                    reject(error);
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