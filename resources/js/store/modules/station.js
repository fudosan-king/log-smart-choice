import axios from 'axios';
import Vue from 'vue';
import globalVaiable from '../../../js/globalHelper';

Vue.use(globalVaiable);

const state = {};

const getters = {};

const actions = {
    getStation() {
        return new Promise((resolve, reject) => {
            // const auth = this.auth;
            // axios({
            //     url: '/stations/list',
            //     method: 'POST',
            //     data: {},
            //     headers: {
            //         'content-type': 'application/json',
            //     },
            //     auth: auth,
            // })
            //     .then(resp => {
            //         resolve(resp.data);
            //     })
            //     .catch(err => {
            //         reject(err);
            //     });
            let station = [
                '山手線',
                '京浜東北線',
                '東海道本線',
                '常磐線',
                '南武線',
                '横浜線',
                '横須賀線',
                '中央線',
                '青梅線',
                '五日市線',
                '武蔵野線',
                '八高線',
                '埼京線',
                '高崎線',
                '宇都宮線',
                '総武線',
                '総武線快速',
                '京葉線',
                '銀座線',
                '丸ノ内線',
                '日比谷線',
                '東西線',
                '千代田線',
                '有楽町線',
                '半蔵門線',
                '南北線',
                '副都心線',
                '湘南新宿ライン',
            ];
            resolve(station);
        });
    },

    getTransportCompany() {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            axios({
                url: '/stations/get-companies',
                method: 'GET',
                data: {},
                headers: {
                    'content-type': 'application/json',
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
    },

    getStationParents() {
        return new Promise((resolve, reject) => {
            const auth = this.auth;
            axios({
                url: '/stations/parent-station',
                method: 'POST',
                data: {},
                headers: {
                    'content-type': 'application/json',
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