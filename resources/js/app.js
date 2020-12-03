require('./bootstrap');

window.Vue = require('vue');

// Estate Componnent VueJS
Vue.component('estateimage-component', require('./components/EstateImagesComponent.vue').default);

const estate = new Vue({
	el: '.page-content',
});