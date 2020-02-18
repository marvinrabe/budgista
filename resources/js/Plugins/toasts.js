import { Notyf } from 'notyf'
import 'notyf/notyf.min.css'

const notyf = new Notyf()

export function flashMessages (messages) {
  for (let flash of messages) {
    const duration = Math.min(Math.max(flash.message.length * 50, 2000), 7000)
    notyf.open({
      icon: false,
      type: flash.level,
      message: flash.message,
      duration
    })
  }
}
