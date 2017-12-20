/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import axios from './http';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('vue-table-action', require('./components/TableAction.vue'));
Vue.component('vue-form', require('./components/Form.vue'));

Vue.prototype.$http = axios;

const app = new Vue({
    el: '#app'
});

require('./main');