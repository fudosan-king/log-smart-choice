import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import estate from './modules/estate';
import district from './modules/district';
import station from './modules/station';
import wishlist from './modules/wishlist';
// import announcement from './modules/announcement';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        estate,
        district,
        station,
        wishlist,
        // announcement
    }
});