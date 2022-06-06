import axios from 'axios';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);

const source = axios.CancelToken.source();

const state = {};

const getters = {};

const actions = {
    addWishList({}, data) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            axios
                .post('/wishlist', data, {
                    headers: {
                        'content-type': 'application/json',
                        AuthorizationBearer: 'Bearer ' + data.accessToken
                    },
                    auth: auth
                })
                .then((resp) => {
                    resolve(resp);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },

    getEstateList({}, data) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            // axios({
            //     url: '/auth/login',
            //     method: 'POST',
            //     data: { username: 'test@gmail.com', password: 'Anhthi090!@#' },
            //     withCredentials: false
            //     // auth: auth,
            //     // cancelToken: source.token
            // }).then((resp) => {
            //     console.log(resp);
            // });
            axios({
                url: '/auth/logout',
                method: 'DELETE',
                headers: {
                    'content-type': 'application/json',
                    Authorization:
                        'Bearer ' +
                        'eyJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2VtYWlsIjoidGVzdEBnbWFpbC5jb20iLCJ1c2VyX25hbWUiOiJOZ3V5ZW4gVGhhbmggSHVuZyIsInVzZXJfaWQiOiI5MWFlZmJkZGRkMWI1ZTM2OGIwZGYyMzkiLCJqdGkiOiJxVW14akdvTDdFU3lCUDlaNkFWM3IiLCJpYXQiOjE2NDk5Mjk0ODQsImV4cCI6MTY0OTkzMzA4NH0.qsZE1nXHe3clZFwk0b38kbJMgVl9sJsNdn1DXtrSCsk'
                },
                // data: { username: 'test@gmail.com', password: 'Anhthi090!@#' },
                withCredentials: false
                // auth: auth,
                // cancelToken: source.token
            }).then((resp) => {
                console.log(resp);
            });
            // axios({ url: '/list', method: 'POST', data: data, auth: auth, cancelToken: source.token })
            //     .then((resp) => {
            //         if (resp.data['data']) {
            //             let data = {
            //                 data: resp.data['data'],
            //                 lastedEstate: resp.data['lasted_estate'],
            //                 total: resp.data.total,
            //                 conditionSearch: resp.data.condition_search,
            //                 paginationInfo: {
            //                     currentPage: resp.data.current_page,
            //                     from: resp.data.from,
            //                     lastPage: resp.data.last_page,
            //                     nextPageUrl: resp.data.next_page_url,
            //                     itemPerPage: resp.data.per_page,
            //                     prevPageUrl: resp.data.prev_page_url,
            //                     to: resp.data.to
            //                 }
            //             };
            //             resolve(data);
            //         }
            //     })
            //     .catch((error) => {
            //         if (axios.isCancel(error)) {
            //             console.log('Request canceled', error.message);
            //             reject(error.message);
            //         } else {
            //             reject(error);
            //             // handle error
            //         }
            //     });
        });
    },

    getEstatesNear({}, data) {
        return new Promise((resolve, reject) => {
            const auth = this.$auth;
            axios({ url: '/estate/near', method: 'POST', data: data, auth: auth })
                .then((resp) => {
                    if (resp.data['data']) {
                        resolve(resp.data['data']);
                    }
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },

    getEstate({}, data) {
        return new Promise((relsove, reject) => {
            axios({ url: '/detail', method: 'POST', data: data })
                .then((resp) => {
                    relsove(resp);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },

    getEstatesRecommend({}, data) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            axios({ url: '/estate/recommend', method: 'POST', data: data, auth: auth })
                .then((resp) => {
                    if (resp.data['data']) {
                        resolve(resp.data['data']);
                    }
                })
                .catch((error) => {
                    reject(error);
                });
        });
    }
};

const mutations = {};

export default {
    state,
    getters,
    actions,
    mutations
};
