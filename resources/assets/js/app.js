/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Vue
 */
import Vue from 'vue';

/*
 * Font Awesome
 */
import FontAwesome from './fontawesome';

Vue.use(FontAwesome);

import Snotify from 'vue-snotify';

Vue.use(Snotify, {
    toast: {
        timeout: 9000
    }
});

/**
 * Validation
 */
import VeeValidate from 'vee-validate';

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
Vue.component(
    'modal',
    require('./components/AppModal.vue')
);

Vue.component(
    'app-form',
    require('./form/AppForm.vue')
);

Vue.component(
    'app-password',
    require('./form/AppPassword.vue')
);

Vue.component(
    'form-group',
    require('./form/FormGroup.vue')
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
    'app-spinner',
    require('./components/AppSpinner.vue')
);

/**
 * Translations
 */
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

Vue.prototype.$formatMonth = (month) => {
    return messages[document.documentElement.lang].month[month.month] + ' ' + month.year;
};

/**
 * Intl
 */
import AppIntl from './intl';

Vue.use(AppIntl);

/**
 * Routes
 */
import VueRouter from 'vue-router';
import routes from './routes.js';

Vue.use(VueRouter);

const router = new VueRouter({routes: routes});

/**
 * Store
 */
import store from './store'

/**
 * Scaffold
 */
import AppLayout from './components/AppLayout';

const Budgista = Vue.extend(AppLayout);

/**
 * And go!
 */
new Budgista({router, store, i18n}).$mount('#app');
