import Vue from 'vue'
import { InertiaApp } from '@inertiajs/inertia-vue'

import { i18n, loadLanguage } from './Plugins/i18n'

import './Plugins/analytics'
import './Plugins/axios'
import './Plugins/meta'
import './Plugins/portal'

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
        return props
      },
    },
  }),
}).$mount(app)
