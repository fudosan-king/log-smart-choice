import axios from "axios";

const state = {};

const getters = {};

const actions = {
    getTabList({}, data) {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            axios({
                url: "/tab-search/list",
                method: "POST",
                data: data,
                headers: {
                    "Content-type": "application/json",
                },
                auth: auth,
            })
                .then((resp) => {
                    if (resp.data) {
                        resolve(resp.data.data);
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
