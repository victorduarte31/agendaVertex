require('./bootstrap');

window.Vue = require('vue');

import Snotify from 'vue-snotify';
import VueTheMask from 'vue-the-mask'
import BootstrapVue from 'bootstrap-vue'

import router from './router/routers';
import store from './vuex/store'
import VueResource from 'vue-resource'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(Snotify, {toast: {showProgressBar: false}});
Vue.use(BootstrapVue);
Vue.use(VueTheMask);
Vue.use(VueResource);

Vue.component('agenda', require('./components/AgendaComponent.vue').default);


const app = new Vue({
    router,
    store,
    el: '#app',
});
