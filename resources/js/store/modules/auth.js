import axios from 'axios';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);
const state = {
    status: '',
    token: Vue.prototype.$getCookie('accessToken') ? Vue.prototype.$getCookie('accessToken') : '',
    refreshToken: Vue.prototype.$getCookie('refreshToken') ? Vue.prototype.$getCookie('refreshToken') : '',
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
            commit('auth_request');
            const customAxios = axios.create({
                baseURL: `${process.env.MIX_APP_URL}`
            });
            let auth = {
                username: `${process.env.MIX_BASIC_AUTH_USERNAME}`,
                password: `${process.env.MIX_BASIC_AUTH_PASSWORD}`,
            }

            axios({
                url: '/login', data: customer, method: 'POST', headers: {
                    'content-type': 'application/json',
                },
                auth: auth,
            })
                .then(resp => {
                    let clientId = resp.data.client_id;
                    let clientSecret = resp.data.client_secret;
                    let accessToken = {
                        "grant_type": "password",
                        "client_id": clientId,
                        "client_secret": clientSecret,
                        "username": customer.email,
                        "password": customer.password,
                        "scope": "*"
                    };
                    this._vm.$setCookie('clientId', clientId, 1);
                    this._vm.$setCookie('clientSecret', clientSecret, 1);
                    this._vm.$setCookie('userName', resp.data.customer.name, 1);

                    customAxios({
                        url: '/oauth/token', data: accessToken, method: 'POST', headers: {
                            'content-type': 'application/json',
                        },
                        auth: auth,
                    })
                        .then(resp => {
                            const tokenInfo = {
                                token: resp.data.access_token,
                                refreshToken: resp.data.refresh_token,
                                userName: this._vm.$getCookie('userName'),
                            }
                            this._vm.$setCookie('accessToken', tokenInfo.token, 1);
                            this._vm.$setCookie('accessToken3d', tokenInfo.token, 1);
                            this._vm.$setCookie('refreshToken', tokenInfo.refreshToken, 1);

                            commit('auth_success', tokenInfo);
                            resolve(resp);
                        }).catch(err => {
                            commit('auth_error');
                            reject(err);
                        });
                })
                .catch(err => {
                    commit('auth_error');
                    this._vm.$setCookie('accessToken', '', 1);
                    this._vm.$setCookie('accessToken3d', '', 1);
                    this._vm.$setCookie('clientId', '', 1);
                    this._vm.$setCookie('clientSecret', '', 1);
                    reject(err);
                });
        });
    },

    logout({ commit }) {
        return new Promise((resolve, reject) => {
            commit('logout');
            let accessToken = this._vm.$getCookie('accessToken', '', 1);
            let auth = {
                username: `${process.env.MIX_BASIC_AUTH_USERNAME}`,
                password: `${process.env.MIX_BASIC_AUTH_PASSWORD}`,
            };
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
                    this._vm.$setCookie('refreshToken', '', 1);
                    this._vm.$setCookie('clientId', '', 1);
                    this._vm.$setCookie('clientSecret', '', 1);
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
                    this._vm.$setCookie('refreshToken', '', 1);
                    reject(err);
                });
            resolve();
        });
    },

    refreshToken({ commit }) {
        return new Promise((resolve, reject) => {
            let refreshToken = this._vm.$getCookie('refreshToken');
            let clientId = this._vm.$getCookie('clientId');
            let clientSecret = this._vm.$getCookie('clientSecret');
            let auth = {
                username: `${process.env.MIX_BASIC_AUTH_USERNAME}`,
                password: `${process.env.MIX_BASIC_AUTH_PASSWORD}`,
            };
            let getAccessToken = {
                "grant_type": "refresh_token",
                "refresh_token": refreshToken,
                "client_id": clientId,
                "client_secret": clientSecret,
                "scope": "*"
            };

            const customAxios = axios.create({
                baseURL: `${process.env.MIX_APP_URL}`
            });

            customAxios({
                url: '/oauth/token', data: getAccessToken, method: 'POST', headers: {
                    'content-type': 'application/json',
                    'Refreshtoken': `${refreshToken}`,
                },
                auth: auth,
            }).then((response) => {
                const tokenInfo = {
                    accessToken: response.data.access_token,
                    refreshToken: response.data.refresh_token
                }
                this._vm.$setCookie('accessToken', tokenInfo.accessToken, 1);
                this._vm.$setCookie('accessToken3d', tokenInfo.accessToken, 1);
                this._vm.$setCookie('refreshToken', tokenInfo.refreshToken, 1);
                commit('refreshToken', tokenInfo);
                resolve(response);
            }).catch(error => {
                this._vm.$setCookie('accessToken', '', 1);
                this._vm.$setCookie('accessToken3d', '', 1);
                this._vm.$setCookie('refreshToken', '', 1);
                commit('logout');
                reject(error);
            });
        });
    },

    googleLogin({ commit }) {
        return new Promise((resolve, reject) => {
            const customAxios = axios.create({
                baseURL: `${process.env.MIX_APP_URL}`
            });
            window.gapi.auth2.getAuthInstance().signIn().then(() => {
                let auth2 = window.gapi.auth2.getAuthInstance();
                let auth = {
                    username: `${process.env.MIX_BASIC_AUTH_USERNAME}`,
                    password: `${process.env.MIX_BASIC_AUTH_PASSWORD}`,
                }

                if (auth2.isSignedIn.get()) {
                    let profile = auth2.currentUser.get().getBasicProfile();
                    let userInfo = {
                        "googleId": profile.getId(),
                        "fullName": profile.getName(),
                        "email": profile.getEmail(),
                        "imageUrl": profile.getImageUrl(),
                    };
                    axios({
                        url: '/google-login', data: userInfo, method: 'POST', headers: {
                            'content-type': 'application/json',
                        },
                        auth: auth,
                    }).then(resp => {
                        let clientId = resp.data.client_id;
                        let clientSecret = resp.data.client_secret;
                        let accessToken = {
                            "grant_type": "password",
                            "client_id": clientId,
                            "client_secret": clientSecret,
                            "username": resp.data.customer.email,
                            "password": userInfo.googleId,
                            "scope": "*"
                        };
                        this._vm.$setCookie('clientId', clientId, 1);
                        this._vm.$setCookie('clientSecret', clientSecret, 1);
                        this._vm.$setCookie('userName', resp.data.customer.name, 1);
                        customAxios({
                            url: '/oauth/token', data: accessToken, method: 'POST', headers: {
                                'content-type': 'application/json',
                            },
                            auth: auth,
                        }).then(resp => {
                            const tokenInfo = {
                                token: resp.data.access_token,
                                refreshToken: resp.data.refresh_token,
                                userName: this._vm.$getCookie('userName'),
                            }
                            commit('auth_success', tokenInfo);
                            resolve(tokenInfo);
                        }).catch(err => {
                            commit('auth_error');
                            reject(err);
                        });
                    }).catch(err => {
                        commit('auth_error');
                        this._vm.$setCookie('accessToken', '', 1);
                        this._vm.$setCookie('accessToken3d', '', 1);
                        this._vm.$setCookie('refreshToken', '', 1);
                        reject(err);
                    });
                }
            }).catch(err => {
                commit('auth_error');
                this._vm.$setCookie('accessToken', '', 1);
                this._vm.$setCookie('accessToken3d', '', 1);
                this._vm.$setCookie('refreshToken', '', 1);
                reject(err);
            });
        })
    },

    googleLogout() {
        
    },
};
const mutations = {
    auth_request(state) {
        state.status = 'loading';
    },

    auth_success(state, tokenInfo) {
        state.status = 'success';
        state.token = tokenInfo.token;
        state.refreshToken = tokenInfo.refreshToken;
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
        state.refreshToken = tokenInfo.refreshToken;
    },
};
export default {
    state,
    getters,
    actions,
    mutations
};