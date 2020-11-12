window.Vue = require('vue');

import vuetify from '../plugins/vuetify'
import VueResource from 'vue-resource'
import Router from './routes'
import VueProgressBar from 'vue-progressbar'
import Auth from './auth.js'
import VueNumber from 'vue-number-animation'
import { Form, HasError, AlertError } from 'vform'
import _ from 'lodash'
import Vuex from 'vuex'


window.Form = Form;
// export const bus = new Vue();

Vue.component('sidebar', require('./components/Addons/Sidebar.vue').default);
Vue.component('navbar', require('./components/Addons/Navbar.vue').default);
Vue.component('usernav', require('./components/Addons/UserNav.vue').default);
Vue.component('sellersidebar', require('./components/Addons/SellerSidebar.vue').default);
Vue.component('sellernav', require('./components/Addons/SellerNav.vue').default);

Vue.use(VueNumber)
Vue.use(VueResource)
Vue.use(Auth)
Vue.use(VueProgressBar, {
    color: 'rgb(30, 144, 255)',
    failedColor: 'red',
    height: '15px'
})
// // // Vue.auth.getToken()
// var token = localStorage.getItem('token')
// Vue.http.headers.common['Authorization'] = 'Bearer ' + token;

const app = new Vue({
    vuetify,
    el: '#app',
    router: Router,
});
