import axios from 'axios';
const state = {};
const getters = {};
const actions = {
    updatePagePost({ }, data) {
        return new Promise((relove, reject) => {
            const auth = this.auth;
            axios({
                url: "/manage-page-post/page-post",
                method: "PUT",
                data: data,
                headers: {
                    "Content-type": "application/json",
                },
                auth: auth,
            })
                .then((resp) => {
                    if (resp.data) {
                        relove(resp.data);
                    }
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },

    getPost({}, data) {
        return new Promise((relove, reject) => {
            const auth = this.auth;
            axios({
                url: "/post/list",
                method: "POST",
                data: data,
                headers: {
                    "Content-type": "application/json",
                },
                auth: auth,
            })
                .then((resp) => {
                    if (resp.data) {
                        relove(resp.data.data);
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
    mutations,
};