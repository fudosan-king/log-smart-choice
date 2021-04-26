import axios from 'axios';
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
                    this._vm.$setCookie('userName', resp.data.customer_name, 1);
                    this._vm.$setCookie('userEmail', resp.data.customer_email, 1);
                    this._vm.$setCookie('userSocialId', resp.data.customer_social_id, 1);
                    this._vm.$setCookie('accessToken', resp.data.access_token, 1);
                    this._vm.$setCookie('accessToken3d', resp.data.access_token, 1);
                    resolve(resp);
                })
                .catch(err => {
                    commit('auth_error');
                    this._vm.$setCookie('accessToken', '', 1);
                    this._vm.$setCookie('accessToken3d', '', 1);
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
                    reject(err);
                });
            resolve();
        });
    },

    googleLogin({ commit }) {
        return new Promise((resolve, reject) => {
            window.gapi.auth2.getAuthInstance().signIn().then(() => {
                let auth2 = window.gapi.auth2.getAuthInstance();
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
                    };
                    axios({
                        url: '/google-login', data: userInfo, method: 'POST', headers: {
                            'content-type': 'application/json',
                        },
                        auth: auth,
                    }).then(resp => {
                        const tokenInfo = {
                            token: resp.data.access_token,
                            customerName: resp.data.customer_name,
                        };
                        this._vm.$setCookie('accessToken', tokenInfo.token, 1);
                        this._vm.$setCookie('accessToken3d', tokenInfo.token, 1);
                        this._vm.$setCookie('userName', tokenInfo.customerName, 1);
                        this._vm.$setCookie('userEmail', resp.data.customer_email, 1);
                        this._vm.$setCookie('userSocialId', resp.data.customer_social_id, 1);
                        commit('auth_success', tokenInfo);
                        resolve(tokenInfo);
                    }).catch(err => {
                        commit('auth_error');
                        this._vm.$setCookie('accessToken', '', 1);
                        this._vm.$setCookie('accessToken3d', '', 1);
                        reject(err);
                    });
                }
            }).catch(err => {
                commit('auth_error');
                this._vm.$setCookie('accessToken', '', 1);
                this._vm.$setCookie('accessToken3d', '', 1);
                reject(err);
            });
        })
    },

    facebookLogin({ commit }) {
        return new Promise(async (resolve, reject) => {
            let vueVM = this._vm;
            const auth = this.auth
            FB.getLoginStatus(function (response) {
                if (response.status === 'connected') {
                    let userInfo = {
                        "socialType": "facebook",
                        "socialId": response.authResponse.userID,
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
                                token: resp.data.access_token,
                                customerName: resp.data.customer_name,
                            };
                            vueVM.$setCookie('accessToken', tokenInfo.token, 1);
                            vueVM.$setCookie('accessToken3d', tokenInfo.token, 1);
                            vueVM.$setCookie('userName', tokenInfo.customerName, 1);
                            vueVM.$setCookie('userEmail', resp.data.customer_email, 1);
                            vueVM.$setCookie('userSocialId', resp.data.customer_social_id, 1);
                            commit('auth_success', tokenInfo);
                            resolve(tokenInfo);
                        })
                        .catch(err => {
                            commit('auth_error');
                            vueVM.$setCookie('accessToken', '', 1);
                            vueVM.$setCookie('accessToken3d', '', 1);
                            reject(err);
                        });
                }
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