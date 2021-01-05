import axios from 'axios';


const state = {
    status: '',
    token: localStorage.getItem('access_token') || '',
    refreshToken: localStorage.getItem('refresh_token') || '',
    customer: {}
};
const getters = {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
    customerInfo: state => {
        return state.customer;
    },
};

const actions = {
    login({ commit }, customer) {
        return new Promise((resolve, reject) => {
            commit('auth_request');
            axios({
                url: '/login', data: customer, method: 'POST', headers: {
                    'content-type': 'application/json'
                }
            })
                .then(resp => {
                    const customerInfo = {
                        token: resp.data.access_token,
                        customer: resp.data.customer,
                        refreshToken: resp.data.refresh_token,
                    }
                    localStorage.setItem('access_token', customerInfo.token);
                    localStorage.setItem('refresh_token', customerInfo.refreshToken);
                    axios.defaults.headers.common['Authorization'] = customerInfo.token;
                    commit('auth_success', customerInfo);
                    resolve(resp);
                })
                .catch(err => {
                    commit('auth_error');
                    localStorage.removeItem('access_token');
                    reject(err);
                });
        });
    },

    logout({ commit }) {
        return new Promise((resolve, reject) => {
            commit('logout');
            let accessToken = localStorage.getItem('access_token');
            axios({
                url: '/logout', method: 'DELETE', headers: {
                    'content-type': 'application/json',
                    'Authorization': `Bearer ${accessToken}`,
                }
            })
                .then(resp => {
                    localStorage.removeItem('access_token');
                    localStorage.removeItem('refresh_token');
                    delete axios.defaults.headers.common['Authorization'];
                    resolve(resp);
                })
                .catch(err => {
                    commit('auth_error');
                    localStorage.removeItem('access_token');
                    reject(err);
                });
            resolve();
        });
    },

    refreshToken({ commit }) {
        return new Promise((resolve, reject) => {
            let accessToken = localStorage.getItem('access_token');
            let refreshToken = localStorage.getItem('refresh_token');
            axios({
                url: '/login', method: 'PUT', headers: {
                    'content-type': 'application/json',
                    'Authorization': `Bearer ${accessToken}`,
                    'Refreshtoken': `${refreshToken}`,
                }
            }).then((response) => {
                const customerInfo = {
                    accessToken: response.data.access_token,
                    refreshToken: response.data.refresh_token,
                    customer: response.data.customer,
                }
                localStorage.setItem('access_token', customerInfo.accessToken);
                localStorage.setItem('refresh_token', customerInfo.refreshToken);
                axios.defaults.headers.common['Authorization'] = customerInfo.accessToken;
                commit('refreshToken', customerInfo);
                resolve(response);
            }).catch(error => {
                localStorage.removeItem('access_token');
                localStorage.removeItem('refresh_token');
                delete axios.defaults.headers.common['Authorization'];
                reject(error);
            });
        });
    }
};
const mutations = {
    auth_request(state) {
        state.status = 'loading';
    },
    auth_success(state, customerInfo) {
        state.status = 'success';
        state.token = customerInfo.token;
        state.refreshToken = customerInfo.refreshToken;
        state.customer = customerInfo.customer;
    },
    auth_error(state) {
        state.status = 'error';
    },
    logout(state) {
        state.status = '';
        state.token = '';
        state.refreshToken = '';
    },
    refreshToken(state, customerInfo) {
        state.status = 'success';
        state.token = customerInfo.accessToken;
        state.refreshToken = customerInfo.refreshToken;
        state.customer = customerInfo.customer;
    },
};
export default {
    state,
    getters,
    actions,
    mutations
};