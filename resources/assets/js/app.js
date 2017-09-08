/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./pace.min');

if (process.env.NODE_ENV !== 'production') {
    console.log('Looks like we are in development mode!');
}

/**
 * Vue
 */
window.Vue = require('vue');

import VueI18n from 'vue-i18n'
import VueRouter from 'vue-router'

/**
 * Third Party Vue Components
 */

// Translations & Dates
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
Vue.use(VueRouter);

/**
 * Vue Components
 */

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

Vue.component(
    'recurrence',
    require('./components/Recurrence.vue')
);

/**
 * Routes
 */

const routes = [
    {
        path: '/budget/:budget',
        name: 'budget',
        component: require('./components/budget/MonthlyView.vue'),
        props: true
    },
    {
        path: '/account/:account_id',
        name: 'account',
        component: require('./components/budget/AccountView.vue'),
        props: true
    }
];

const router = new VueRouter({
    routes // short for `routes: routes`
});

const app = new Vue({i18n, router}).$mount('#app');

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