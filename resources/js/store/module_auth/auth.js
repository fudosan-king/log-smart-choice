import axios from 'axios';


const state = {
    status: '',
    token: localStorage.getItem('access_token') || '',
    user: {}
};
const getters = {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
};
const actions = {
    login({ commit }, user) {
        // console.log('here');
        return new Promise((resolve, reject) => {
            commit('auth_request');
            axios({ url: '/customer/login', data: user, method: 'POST' })
                .then(resp => {
                    const token = resp.data.token;
                    const user = resp.data.user;
                    localStorage.setItem('access_token', token);
                    axios.defaults.headers.common['Authorization'] = token;
                    commit('auth_success', token, user);
                    resolve(resp);
                })
            .catch(err => {
                if (err.response && err.response.data) {
                    commit('auth_error');
                    localStorage.removeItem('token');
                    reject(err);
                }
            })
        })
    },
};
const mutations = {
    auth_request(state) {
        state.status = 'loading'
    },
    auth_success(state, token, user) {
        state.status = 'success'
        state.token = token
        state.user = user
    },
    auth_error(state) {
        state.status = 'error'
    },
    logout(state) {
        state.status = ''
        state.token = ''
    },
};
export default {
    state,
    getters,
    actions,
    mutations
};