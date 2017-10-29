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

/**
 * Third Party Vue Components
 */

// Translations & Dates
import VueI18n from 'vue-i18n'

Vue.use(VueI18n);

const messages = {
    en: require('./lang/en.json'),
    de: require('./lang/de.json')
};

const i18n = new VueI18n({
    locale: document.documentElement.lang,
    fallbackLocale: 'en',
    messages: messages,
    silentTranslationWarn: process.env.NODE_ENV === 'production'
});

// Bootstrap
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);

// Router
import VueRouter from 'vue-router'

Vue.use(VueRouter);

// Vuex
import Vuex from 'vuex'

Vue.use(Vuex);

// Validations
import VeeValidate from 'vee-validate';

Vue.use(VeeValidate, {
    validity: true
});

/**
 * Vue Components
 */

/* Passport Components

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

*/

Vue.component(
    'app-layout',
    require('./components/AppLayout.vue')
);

Vue.component(
    'app-sidebar',
    require('./components/AppSidebar.vue')
);

Vue.component(
    'app-sidebar-toggle',
    require('./components/AppSidebarToggle.vue')
);

Vue.component(
    'app-window',
    require('./components/AppWindow.vue')
);

/**
 * Intl
 */

import AppIntl from './intl'

Vue.use(AppIntl);

/**
 * Routes
 */

const routes = [
    {
        path: '/',
        name: 'budget.month',
        component: require('./components/budget/MonthlyView.vue'),
        props: true
    },
    {
        path: '/account/:account_id',
        name: 'budget.account',
        component: require('./components/budget/AccountView.vue'),
        props: true
    },
    {
        path: '/account/:account_id/newTransaction',
        name: 'budget.newTransaction',
        component: require('./components/transactions/New.vue'),
        props: true
    },
    {
        path: '/transaction/:transaction_id',
        name: 'budget.transaction',
        component: require('./components/transactions/Edit.vue'),
        props: true
    }
];

const router = new VueRouter({routes});

import store from './store'

const app = new Vue({router, store, i18n}).$mount('#app');

/**
 * Menu
 */

function toggleClassMenu() {
    let myMenu = document.querySelector(".menu");
    myMenu.classList.add("menu--animatable");
    if (!myMenu.classList.contains("menu--visible")) {
        myMenu.classList.add("menu--visible");
    } else {
        myMenu.classList.remove('menu--visible');
    }
}

function hideMenu() {
    let myMenu = document.querySelector(".menu");
    myMenu.classList.add("menu--animatable");
    myMenu.classList.remove('menu--visible');
}

function OnTransitionEnd() {
    let myMenu = document.querySelector(".menu");
    myMenu.classList.remove("menu--animatable");
}

$('#app').on('click', '.menu-toggle', toggleClassMenu);
$('#app').on('click', '.nav-link-main', hideMenu);