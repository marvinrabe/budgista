/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Vue
 */
window.Vue = require('vue');

Vue.component('app-password', require('./components/form/AppPassword.vue'));

const app = new Vue().$mount('#app');