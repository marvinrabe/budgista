import Vue from 'vue'

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
