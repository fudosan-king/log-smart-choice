import axios from 'axios';
const state = {};
const getters = {};
const actions = {
    getCityList({ }, data) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            axios({
                url: "/city/list",
                method: "POST",
                data: data,
                headers: {
                    "Content-type": "application/json",
                },
                auth: auth,
            })
                .then((resp) => {
                    if (resp.data) {
                        resolve(resp.data);
                    }
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },
};

const mutations = {};

export default {
    state,
    getters,
    actions,
    mutations,
};