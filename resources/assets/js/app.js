window.axios = require('axios')

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
 * Portals
 */
import PortalVue from 'portal-vue'

Vue.use(PortalVue)

/**
 * Toasts
 */
import Snotify from 'vue-snotify'

Vue.use(Snotify, {
    toast: {
        timeout: 9000
    }
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

import {i18n} from './i18n'
import {store} from './store'
import {router} from './router'
import './auth'
import './http'
import './validation'

/**
 * And go!
 */
const App = require('./components/App.vue')

window.app = new Vue({
    i18n,
    store,
    router,
    render: (h) => h(App)
}).$mount('#app')
