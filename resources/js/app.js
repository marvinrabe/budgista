import Vue from 'vue'
import { InertiaApp } from '@inertiajs/inertia-vue'

import { i18n, loadLanguage } from './Plugins/i18n'
import { flashMessages } from './Plugins/toasts'

import { DropdownPlugin } from 'bootstrap-vue'
Vue.use(DropdownPlugin)

Vue.use(InertiaApp)

const app = document.getElementById('app')

new Vue({
  i18n,
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => import(`./Pages/${name}`).then(module => module.default),
      transformProps: props => {
        loadLanguage(props.user)
        flashMessages(props.flash)
        return props
      },
    },
  }),
}).$mount(app)
