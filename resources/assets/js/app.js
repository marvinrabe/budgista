/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

if (process.env.NODE_ENV !== 'production') {
    console.log('Looks like we are in development mode!');
}

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
    en: require('./lang/en.json')
};

const i18n = new VueI18n({
    locale: window.locale,
    fallbackLocale: 'en',
    messages: messages,
    silentTranslationWarn: process.env.NODE_ENV === 'production'
});

// Currencies
Vue.use(require('vue-intl'));
Vue.setLocale(window.locale);

// Bootstrap
Vue.use(require('bootstrap-vue'));

// Router
import VueRouter from 'vue-router'
Vue.use(VueRouter);

// Vuex
import Vuex from 'vuex'
Vue.use(Vuex);

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
    'window',
    require('./components/Window.vue')
);

Vue.component(
    'budget-layout',
    require('./components/budget/Layout.vue')
);

/**
 * Routes
 */

const routes = [
    {
        path: '/budgets/:budget_id',
        name: 'budget',
        component: require('./components/budget/Layout.vue'),
        props: true,
        children: [
            {
                path: '/budgets/:budget_id/',
                name: 'budget.month',
                component: require('./components/budget/MonthlyView.vue'),
                props: true
            },
            {
                path: '/budgets/:budget_id/account/:account_id',
                name: 'budget.account',
                component: require('./components/budget/AccountView.vue'),
                props: true
            }
        ]
    }

];

const router = new VueRouter({
    mode: 'history',
    routes: routes // short for `routes: routes`
});

const bus = new Vue();

const app = new Vue({bus, router, i18n}).$mount('#app');

/**
 * Menu
 */

function toggleClassMenu() {
    myMenu.classList.add("menu--animatable");
    if (!myMenu.classList.contains("menu--visible")) {
        myMenu.classList.add("menu--visible");
    } else {
        myMenu.classList.remove('menu--visible');
    }
}

function OnTransitionEnd() {
    myMenu.classList.remove("menu--animatable");
}

let myMenu = document.querySelector(".menu");
if (myMenu) {
    let openMenu = document.querySelector(".menu-open");
    let closeMenu = document.querySelector(".menu-close");
    myMenu.addEventListener("transitionend", OnTransitionEnd, false);
}

$('#app').on('click', '.menu-toggle', toggleClassMenu);