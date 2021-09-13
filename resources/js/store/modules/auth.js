import axios from 'axios';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);
const state = {
    status: '',
    token: Vue.prototype.$getLocalStorage('accessToken') ? Vue.prototype.$getLocalStorage('accessToken') : '',
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
                    Vue.prototype.$setCookie('accessToken3d', resp.data.data.access_token, 1);
                    Vue.prototype.$setLocalStorage('userName', resp.data.data.customer_name);
                    Vue.prototype.$setLocalStorage('userEmail', resp.data.data.customer_email);
                    Vue.prototype.$setLocalStorage('userSocialId', resp.data.data.customer_social_id);
                    Vue.prototype.$setLocalStorage('accessToken', resp.data.data.access_token);
                    Vue.prototype.$setLocalStorage('accessToken3d', resp.data.data.access_token);
                    resolve(resp);
                })
                .catch(err => {
                    commit('auth_error');
                    this._vm.$setCookie('accessToken3d', '', 1);
                    this._vm.$removeAuthLocalStorage();
                    reject(err);
                });
        });
    },

    logout({ commit }) {
        return new Promise((resolve, reject) => {
            commit('logout');
            let accessToken = Vue.prototype.$getLocalStorage('accessToken');
            const auth = this.auth;
            axios({
                url: '/logout', method: 'DELETE', headers: {
                    'content-type': 'application/json',
                    'AuthorizationBearer': `Bearer ${accessToken}`,
                },
                auth: auth,
            })
                .then(resp => {
                    this._vm.$setCookie('accessToken3d', '', 1);
                    this._vm.$removeLocalStorage('accessToken');
                    this._vm.$removeLocalStorage('accessToken3d');
                    this._vm.$removeLocalStorage('userName');
                    this._vm.$removeLocalStorage('userEmail');
                    this._vm.$removeLocalStorage('userSocialId');
                    this._vm.$removeLocalStorage('announcement_count');
                    delete axios.defaults.headers.common['Authorization'];
                    let auth2 = window.gapi.auth2.getAuthInstance();
                    if (auth2) {
                        auth2.signOut();
                    }
                    resolve(resp);
                })
                .catch(err => {
                    commit('auth_error');
                    this._vm.$setCookie('accessToken3d', '', 1);
                    this._vm.$removeAuthLocalStorage();
                    this._vm.$removeLocalStorage('announcement_count');
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
                        this._vm.$setCookie('accessToken3d', tokenInfo.token, 1);
                        Vue.prototype.$setLocalStorage('accessToken', tokenInfo.token);
                        Vue.prototype.$setLocalStorage('userName', tokenInfo.customerName);
                        Vue.prototype.$setLocalStorage('userEmail', resp.data.data.customer_email);
                        Vue.prototype.$setLocalStorage('userSocialId', resp.data.data.customer_social_id);
                        commit('auth_success', tokenInfo);
                        resolve(tokenInfo);
                    }).catch(err => {
                        commit('auth_error');
                        this._vm.$setCookie('accessToken3d', '', 1);
                        this._vm.$removeAuthLocalStorage();
                        reject(err);
                    });
                }
            }).catch(err => {
                commit('auth_error');
                this._vm.$setCookie('accessToken3d', '', 1);
                this._vm.$removeAuthLocalStorage();
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
                            vueVM.$setCookie('accessToken3d', tokenInfo.token, 1);
                            Vue.prototype.$setLocalStorage('accessToken', tokenInfo.token);
                            Vue.prototype.$setLocalStorage('userName', tokenInfo.customerName);
                            Vue.prototype.$setLocalStorage('userEmail', resp.data.data.customer_email);
                            Vue.prototype.$setLocalStorage('userSocialId', resp.data.data.customer_social_id);
                            commit('auth_success', tokenInfo);
                            resolve(tokenInfo);
                        })
                        .catch(err => {
                            commit('auth_error');
                            vueVM.$setCookie('accessToken3d', '', 1);
                            Vue.prototype.$removeAuthLocalStorage();
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