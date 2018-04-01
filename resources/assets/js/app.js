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

/**
 * Toasts
 */
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
    'app-button',
    require('./form/AppButton.vue')
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
 * Scaffold
 */
import AppLayout from './components/AppLayout';

const Budgista = Vue.extend(AppLayout);

/**
 * And go!
 */
import {i18n} from './i18n'
import {router} from './router'
import store from './store'

new Budgista({i18n, router, store}).$mount('#app');
