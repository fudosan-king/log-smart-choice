import Vue from 'vue';
import Vuex from 'vuex';
// import auth from './module_auth/auth';
import axios from 'axios';

Vue.use(Vuex);

const token = localStorage.getItem('access_token')
if (token) {
    Vue.prototype.$http.defaults.headers.common['Authorization'] = token
}


export default new Vuex.Store({
    state : {
        status: '',
        token: localStorage.getItem('access_token') || '',
        user: {}
    },
    getters : {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
    },
    actions : {
        login({ commit }, user) {
            console.log('here');
            return new Promise((resolve, reject) => {
                commit('auth_request');
                console.log('here02');
                // axios({ url: '/customer/login', data: user, method: 'POST' })
                axios.post({ url: '/customer/login', data: user})
                    .then(resp => {
                        console.log(resp);
                        // const token = resp.data.token;
                        // const user = resp.data.user;
                        // localStorage.setItem('access_token', token);
                        // axios.defaults.headers.common['Authorization'] = token;
                        // commit('auth_success', token, user);
                        // resolve(resp);
                        console.log('here03');
                    })
                    .catch(error => {
                        console.log(error.status);
                      });
                    // .catch(err => {
                    //     console.log('here09');
                    //     console.log(err);
                    //     return err;
                    //     // if (err.response && err.response.data) {
                    //         commit('auth_error');
                    //         localStorage.removeItem('token');
                    //         reject(err);
                    //     // }
                    // })
            })
        },
    },
    mutations : {
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
    },

});
