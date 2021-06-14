import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import estate from './modules/estate';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        estate,
    }
});