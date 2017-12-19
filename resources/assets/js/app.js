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
import VueRouter from 'vue-router'
import VeeValidate from 'vee-validate';
import FontAwesome from './fontawesome'
import AppIntl from './intl'
import store from './store'

Vue.use(VueI18n);
Vue.use(FontAwesome);

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
    'app-toolbar',
    require('./components/AppToolbar.vue')
);

Vue.component(
    'ellipsis',
    require('./components/AppEllipsis.vue')
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
        name: 'budget',
        component: require('./components/budget/Index.vue')
    },
    {
        path: '/settings',
        name: 'settings',
        component: require('./components/settings/Index.vue'),
        children: [
            {
                path: '',
                name: 'settings.account',
                component: require('./components/settings/Account.vue')
            },
            {
                path: 'security',
                name: 'settings.security',
                component: require('./components/settings/Security.vue')
            }
        ]
    },
    {
        path: '/account/:account_id',
        name: 'account',
        component: require('./components/accounts/Index.vue'),
        props: true
    },
    {
        path: '/account/:account_id/newTransaction',
        name: 'transaction.new',
        component: require('./components/transactions/New.vue'),
        props: true
    },
    {
        path: '/transaction/:transaction_id',
        name: 'transaction.edit',
        component: require('./components/transactions/Edit.vue'),
        props: true
    }
];

const router = new VueRouter({routes});

const app = new Vue({router, store, i18n}).$mount('#app');
