window.Vue = require('vue');

import vuetify from '../plugins/vuetify'
import VueResource from 'vue-resource'
import Router from './routes'
import VueProgressBar from 'vue-progressbar'
import Auth from './auth'

Vue.component('sidebar', require('./components/Addons/Sidebar.vue').default);
Vue.component('navbar', require('./components/Addons/Navbar.vue').default);

Vue.use(VueResource)
Vue.use(Auth)
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
})

const app = new Vue({
    vuetify,
    el: '#app',
    router: Router,
});
