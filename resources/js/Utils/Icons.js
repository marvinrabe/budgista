import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { prepareComponent } from '@/helpers'

export function iconComponent (props = {}) {
  return prepareComponent(FontAwesomeIcon, props)
}
