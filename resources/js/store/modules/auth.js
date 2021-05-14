import axios from 'axios';
import { reject } from 'lodash';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);
const state = {
    status: '',
    token: Vue.prototype.$getCookie('accessToken') ? Vue.prototype.$getCookie('accessToken') : '',
    customer: {}
};
const getters = {
    isLoggedIn: state => state.token ? state.token : '',
    authStatus: state => state.status,
    customerInfo: state => {
        return state.customer;
    },
};

const actions = {
    login({ commit }, customer) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            commit('auth_request');
            axios({
                url: '/login', data: customer, method: 'POST', headers: {
                    'content-type': 'application/json',
                },
                auth: auth,
            })
                .then(resp => {
                    this._vm.$setCookie('userName', resp.data.data.customer_name, 1);
                    this._vm.$setCookie('userEmail', resp.data.data.customer_email, 1);
                    this._vm.$setCookie('userSocialId', resp.data.data.customer_social_id, 1);
                    this._vm.$setCookie('accessToken', resp.data.data.access_token, 1);
                    this._vm.$setCookie('accessToken3d', resp.data.data.access_token, 1);
                    resolve(resp);
                })
                .catch(err => {
                    commit('auth_error');
                    this._vm.$setCookie('accessToken', '', 1);
                    this._vm.$setCookie('accessToken3d', '', 1);
                    this._vm.$setCookie('userName', '', 1);
                    this._vm.$setCookie('userEmail', '', 1);
                    this._vm.$setCookie('userSocialId', '', 1);
                    reject(err);
                });
        });
    },

    logout({ commit }) {
        return new Promise((resolve, reject) => {
            commit('logout');
            let accessToken = this._vm.$getCookie('accessToken', '', 1);
            const auth = this.auth;
            axios({
                url: '/logout', method: 'DELETE', headers: {
                    'content-type': 'application/json',
                    'AuthorizationBearer': `Bearer ${accessToken}`,
                },
                auth: auth,
            })
                .then(resp => {
                    this._vm.$setCookie('accessToken', '', 1);
                    this._vm.$setCookie('accessToken3d', '', 1);
                    this._vm.$setCookie('userName', '', 1);
                    this._vm.$setCookie('userEmail', '', 1);
                    this._vm.$setCookie('userSocialId', '', 1);
                    delete axios.defaults.headers.common['Authorization'];
                    let auth2 = window.gapi.auth2.getAuthInstance();
                    if (auth2) {
                        auth2.signOut();
                    }
                    resolve(resp);
                })
                .catch(err => {
                    commit('auth_error');
                    this._vm.$setCookie('accessToken', '', 1);
                    this._vm.$setCookie('accessToken3d', '', 1);
                    this._vm.$setCookie('userName', '', 1);
                    this._vm.$setCookie('userEmail', '', 1);
                    this._vm.$setCookie('userSocialId', '', 1);
                    reject(err);
                });
            resolve();
        });
    },

    googleLogin({ commit }) {
        return new Promise((resolve, reject) => {
            let auth2 = window.gapi.auth2.getAuthInstance();
            auth2.signIn().then(() => {
                let userAuth = auth2.currentUser.get().getAuthResponse();
                const auth = this.auth
                if (auth2.isSignedIn.get()) {
                    let profile = auth2.currentUser.get().getBasicProfile();
                    let userInfo = {
                        "googleId": profile.getId(),
                        "fullName": profile.getName(),
                        "email": profile.getEmail(),
                        "imageUrl": profile.getImageUrl(),
                        "socialType": "google",
                        "socialId": profile.getId(),
                        "token": userAuth.access_token,
                    };
                    axios({
                        url: '/google-login', data: userInfo, method: 'POST', headers: {
                            'content-type': 'application/json',
                        },
                        auth: auth,
                    }).then(resp => {
                        const tokenInfo = {
                            token: resp.data.data.access_token,
                            customerName: resp.data.data.customer_name,
                        };
                        this._vm.$setCookie('accessToken', tokenInfo.token, 1);
                        this._vm.$setCookie('accessToken3d', tokenInfo.token, 1);
                        this._vm.$setCookie('userName', tokenInfo.customerName, 1);
                        this._vm.$setCookie('userEmail', resp.data.data.customer_email, 1);
                        this._vm.$setCookie('userSocialId', resp.data.data.customer_social_id, 1);
                        commit('auth_success', tokenInfo);
                        resolve(tokenInfo);
                    }).catch(err => {
                        commit('auth_error');
                        this._vm.$setCookie('accessToken', '', 1);
                        this._vm.$setCookie('accessToken3d', '', 1);
                        this._vm.$setCookie('userName', '', 1);
                        this._vm.$setCookie('userEmail', '', 1);
                        this._vm.$setCookie('userSocialId', '', 1);
                        reject(err);
                    });
                }
            }).catch(err => {
                commit('auth_error');
                this._vm.$setCookie('accessToken', '', 1);
                this._vm.$setCookie('accessToken3d', '', 1);
                this._vm.$setCookie('userName', '', 1);
                this._vm.$setCookie('userEmail', '', 1);
                this._vm.$setCookie('userSocialId', '', 1);
                reject(err);
            });
        })
    },

    facebookLogin({ commit }) {
        return new Promise((resolve, reject) => {
            let vueVM = this._vm;
            const auth = this.auth;
            FB.getLoginStatus(function (response) {
                if (response.status === 'connected') {
                    let userInfo = {
                        "socialType": "facebook",
                        "socialId": response.authResponse.userID,
                        "token": response.authResponse.accessToken,
                    };

                    axios({
                        url: '/facebook-login',
                        data: userInfo,
                        method: 'POST',
                        headers: {
                            'content-type': 'application/json'
                        },
                        auth: auth
                    })
                        .then(resp => {
                            const tokenInfo = {
                                token: resp.data.data.access_token,
                                customerName: resp.data.data.customer_name,
                            };
                            vueVM.$setCookie('accessToken', tokenInfo.token, 1);
                            vueVM.$setCookie('accessToken3d', tokenInfo.token, 1);
                            vueVM.$setCookie('userName', tokenInfo.customerName, 1);
                            vueVM.$setCookie('userEmail', resp.data.data.customer_email, 1);
                            vueVM.$setCookie('userSocialId', resp.data.data.customer_social_id, 1);
                            commit('auth_success', tokenInfo);
                            resolve(tokenInfo);
                        })
                        .catch(err => {
                            commit('auth_error');
                            vueVM.$setCookie('accessToken', '', 1);
                            vueVM.$setCookie('accessToken3d', '', 1);
                            vueVM.$setCookie('userEmail', '', 1);
                            vueVM.$setCookie('userSocialId', '', 1);
                            reject(err);
                        });
                }
            });
        });
    },

    reconfirmEmail({ commit }, data) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            commit('auth_request');
            axios({
                url: '/reconfirmation-email', method: 'POST', data: data, auth: auth, headers: {
                    'content-type': 'application/json'
                },
            })
                .then(resp => {
                    resolve(resp);
                })
                .catch(error => {
                    reject(error);
                });
        });
    },

    forgotPassword({ commit }, data) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            commit('auth_request');
            axios({
                url: '/forgot-password', method: 'POST', data: data, auth: auth, headers: {
                    'content-type': 'application/json'
                },
            })
                .then(resp => {
                    resolve(resp);
                })
                .catch(error => {
                    reject(error);
                });
        });
    },

    verifyEmail({ commit }, data) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            commit('auth_request');
            axios({
                url: '/verify', method: 'POST', data: data, auth: auth, headers: {
                    'content-type': 'application/json'
                },
            }).then(resp => {
                resolve(resp);
            }).catch(error => {
                reject(error);
            });
        });
    }
};

const mutations = {
    auth_request(state) {
        state.status = 'loading';
    },

    auth_success(state, tokenInfo) {
        state.status = 'success';
        state.token = tokenInfo.token;
    },

    auth_error(state) {
        state.status = 'error';
    },

    logout(state) {
        state.status = '';
        state.token = '';
        state.refreshToken = '';
    },

    refreshToken(state, tokenInfo) {
        state.status = 'success';
        state.token = tokenInfo.accessToken;
    },
};
export default {
    state,
    getters,
    actions,
    mutations
};