import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import estate from './modules/estate';
import district from './modules/district';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        estate,
        district,
    }
});