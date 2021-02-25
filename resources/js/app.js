require('./bootstrap');

window.Vue = require('vue');

// Estate Componnent VueJS
Vue.component('estateimage-component', require('./components/EstateImagesComponent.vue').default);
Vue.component('estatemainphoto-component', require('./components/EstateMainPhotoComponent.vue').default);
Vue.component('estatebeforafter-component', require('./components/EstateBeforAfterComponent.vue').default);
Vue.component('estate-description-component', require('./components/EstateDescriptionComponent.vue').default);
Vue.component('estate-equipment-component', require('./components/EstateEquipmentComponent.vue').default);
Vue.component('estate-flooring-component', require('./components/EstateFlooringComponent.vue').default);

Vue.component('vuecarousel-component', require('./components/VueCarouselComponent.vue').default);

const estate = new Vue({
	el: '.page-content',
});