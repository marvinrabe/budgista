window._ = require('lodash')
window.axios = require('axios')

/**
 * Initialize Raven for error logging with sentry, but only on production builds.
 */
import Raven from 'raven-js'
import {sentryUrl} from './config.js'

if (process.env.NODE_ENV === 'production') {
    Raven
        .config(sentryUrl)
        .install()
}

/**
 * Vue
 */
import Vue from 'vue'

/*
 * Font Awesome
 */
import FontAwesome from './fontawesome'

Vue.use(FontAwesome)

/**
 * Toasts
 */
import Snotify from 'vue-snotify'

Vue.use(Snotify, {
    toast: {
        timeout: 9000
    }
})

/**
 * Validation
 */
import VeeValidate from 'vee-validate'

Vue.use(VeeValidate, {
    validity: true
})

// Focus
Vue.directive('focus', {
    // When the bound element is inserted into the DOM...
    inserted: function (el) {
        // Focus the element
        el.focus()
    }
})

/**
 * Vue Components
 */
Vue.component(
    'modal',
    require('./components/AppModal.vue')
)

Vue.component(
    'app-form',
    require('./components/form/AppForm.vue')
)

Vue.component(
    'app-password',
    require('./components/form/AppPassword.vue')
)

Vue.component(
    'app-button',
    require('./components/form/AppButton.vue')
)

Vue.component(
    'form-group',
    require('./components/form/AppFormGroup.vue')
)

Vue.component(
    'app-toolbar',
    require('./components/AppToolbar.vue')
)

Vue.component(
    'ellipsis',
    require('./components/AppEllipsis.vue')
)

Vue.component(
    'app-spinner',
    require('./components/AppSpinner.vue')
)

/**
 * And go!
 */
import {i18n} from './i18n'
import {store} from './store'
import {router} from './router'
import './auth'
import './http'

const App = Vue.extend(require('./components/App.vue'));

window.app = new App({
    i18n,
    store,
    router
}).$mount('#app')
