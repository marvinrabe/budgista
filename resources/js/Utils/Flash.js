import { Notyf } from 'notyf'
import color from 'open-color/open-color'

const notyf = new Notyf({
  types: [
    {
      type: 'success',
      className: 'notyf__toast--success',
      backgroundColor: color.green[6],
      icon: {
        className: 'notyf__icon--success',
        tagName: 'i',
      },
    },
    {
      type: 'error',
      className: 'notyf__toast--error',
      backgroundColor: color.red[6],
      icon: {
        className: 'notyf__icon--error',
        tagName: 'i',
      },
    },
  ]
})

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
