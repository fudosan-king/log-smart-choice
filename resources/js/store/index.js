import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import estate from './modules/estate';
import city from './modules/city';
import station from './modules/station';
import wishlist from './modules/wishlist';
import tablist from './modules/tab';
import transport from './modules/transport';
import district from './modules/district';
// import announcement from './modules/announcement';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        estate,
        city,
        station,
        wishlist,
        tablist,
        transport,
        district
        // announcement
    }
});