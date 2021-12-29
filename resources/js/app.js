require('./bootstrap');

window.Vue = require('vue');

// Estate Componnent VueJS
Vue.component('estateimage-component',() => import('./components/EstateImagesComponent.vue'));
Vue.component('estatemainphoto-component', () => import('./components/EstateMainPhotoComponent.vue'));
Vue.component('post-image-component', () => import('./components/PostImageComponent.vue'));
// Vue.component('estatebeforafter-component', () => import('./components/EstateBeforAfterComponent.vue'));
// Vue.component('estate-description-component', () => import('./components/EstateDescriptionComponent.vue'));
// Vue.component('estate-equipment-component', () => import('./components/EstateEquipmentComponent.vue'));
// Vue.component('estate-flooring-component', () => import('./components/EstateFlooringComponent.vue'));

// Vue.component('vuecarousel-component', () => import('./components/VueCarouselComponent.vue'));

new Vue({
	el: '.page-content',
});