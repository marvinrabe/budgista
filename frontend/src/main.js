import Vue from 'vue'
import App from './App.vue'

import i18n from './i18n'
import router from './router'
import store from './store'

import './auth'
import './fontawesome'
import './http'
import './registerServiceWorker'
import './validation'

Vue.config.productionTip = false

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
    require('./components/AppModal.vue').default
)

Vue.component(
    'app-form',
    require('./components/form/AppForm.vue').default
)

Vue.component(
    'app-password',
    require('./components/form/AppPassword.vue').default
)

Vue.component(
    'app-button',
    require('./components/form/AppButton.vue').default
)

Vue.component(
    'form-group',
    require('./components/form/AppFormGroup.vue').default
)

Vue.component(
    'app-toolbar',
    require('./components/AppToolbar.vue').default
)

Vue.component(
    'ellipsis',
    require('./components/AppEllipsis.vue').default
)

Vue.component(
    'app-spinner',
    require('./components/AppSpinner.vue').default
)


new Vue({
    i18n,
    router,
    store,
    render: h => h(App)
}).$mount('#app')
