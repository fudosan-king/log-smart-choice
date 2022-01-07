import axios from 'axios';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);

const state = {};

const getters = {};

const actions = {

    getWishlist({ }, data) {
        return new Promise((relove, reject) => {
            const auth = this.auth;
            let accessToken = `Bearer ${data.accessToken}`;
            axios({
                url: '/wishlist/list', method: 'POST', data: data, headers: {
                    'Content-type': 'application/json',
                    'AuthorizationBearer': accessToken
                }, auth: auth
            })
                .then(resp => {
                    if (resp.data['data']) {
                        let data = {
                            'data': resp.data['data'],
                            'paginationInfo': {
                                'currentPage': resp.data.data.current_page,
                                'from': resp.data.data.from,
                                'lastPage': resp.data.data.last_page,
                                'nextPageUrl': resp.data.data.next_page_url,
                                'itemPerPage': resp.data.data.per_page,
                                'prevPageUrl': resp.data.data.prev_page_url,
                                'to': resp.data.data.to,
                            }
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