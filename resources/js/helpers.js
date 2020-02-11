import Vue from 'vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Formatter from '@/Utils/Money'

export const formatter = new Formatter('de', 'EUR')

export const isProduction = process.env.NODE_ENV === 'production'

export function prepareComponent (component, props = {}) {
  return Vue.component(component.name, {
    functional: true,
    render: function (createElement, context) {
      return createElement(component, {
          ...context.data,
          props: props
        },
        context.children)
    }
  })
}

export function iconComponent (props = {}) {
  return prepareComponent(FontAwesomeIcon, props)
}
