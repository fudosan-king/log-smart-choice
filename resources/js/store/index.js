import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import customer from './modules/customer';
import estate from './modules/estate';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        customer,
        estate,
    }
});