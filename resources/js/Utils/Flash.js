import { Notyf } from 'notyf'

const notyf = new Notyf()

export function flashMessages (messages) {
  for (let flash of messages) {
    const duration = Math.min(Math.max(flash.message.length * 50, 2000), 7000)
    notyf.open({
      type: flash.level,
      message: flash.message,
      duration
    })
  }
}
