import Vue from 'vue'
import Toasted from 'vue-toasted'

Vue.use(Toasted, {
  position: 'bottom-center'
})

export function flashMessages (messages) {
  for (let flash of messages) {
    const duration = Math.min(Math.max(flash.message.length * 50, 2000), 7000)
    Vue.toasted.show(flash.message, { duration, type: flash.level })
  }
}
