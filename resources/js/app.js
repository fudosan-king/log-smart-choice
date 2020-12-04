require('./bootstrap');

window.Vue = require('vue');

// Estate Componnent VueJS
Vue.component('estateimage-component', require('./components/EstateImagesComponent.vue').default);

Vue.component('vuecarousel-component', require('./components/VueCarouselComponent.vue').default);

const estate = new Vue({
	el: '.page-content',
});