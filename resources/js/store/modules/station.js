import axios from 'axios';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);

const state = {};

const getters = {};

const actions = {
    getStationsHardCodeSearch() {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            axios({
                url: '/stations/hardcode-search',
                method: 'POST',
                data: {},
                headers: {
                    'content-type': 'application/json'
                },
                auth: auth,
            })
                .then(resp => {
                    resolve(resp.data.data);
                })
                .catch(err => {
                    reject(err);
                });
        })
    }
};


const mutations = {};

export default {
    state,
    getters,
    actions,
    mutations
};