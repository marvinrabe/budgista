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

import fontawesome from '@fortawesome/fontawesome';
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import { faEnvelope, faTrashAlt } from '@fortawesome/fontawesome-free-regular';
import { faTimes, faPlus, faPencilAlt, faSync, faCheck, faChevronLeft, faChevronRight, faBars } from '@fortawesome/fontawesome-free-solid'

fontawesome.library.add(faEnvelope, faTimes, faPlus, faTrashAlt, faPencilAlt, faSync, faCheck, faChevronLeft, faChevronRight, faBars);

Vue.component(FontAwesomeIcon.name, FontAwesomeIcon);

/**
 * Third Party Vue Components
 */
// Translations & Dates
import VueI18n from 'vue-i18n'
import VueRouter from 'vue-router'
import VeeValidate from 'vee-validate';
import store from './store'
import AppIntl from './intl'

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

Vue.use(VueRouter);

Vue.use(VeeValidate, {
    validity: true
});

// Focus
Vue.directive('focus', {
    // When the bound element is inserted into the DOM...
    inserted: function (el) {
        // Focus the element
        el.focus()
    }
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
    'modal',
    require('./components/AppModal.vue')
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
    'app-spinner',
    require('./components/AppSpinner.vue')
);

Vue.component(
    'app-window',
    require('./components/AppWindow.vue')
);

/**
 * Intl
 */

Vue.use(AppIntl);

/**
 * Routes
 */

const routes = [
    {
        path: '/',
        name: 'budget.month',
        component: require('./components/budget/Index.vue'),
        props: true
    },
    {
        path: '/account/:account_id',
        name: 'budget.account',
        component: require('./components/accounts/Index.vue'),
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

const app = new Vue({router, store, i18n}).$mount('#app');
