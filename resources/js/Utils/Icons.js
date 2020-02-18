import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { prepareComponent } from '@/Utils/Component'

export function iconComponent (props = {}) {
  return prepareComponent(FontAwesomeIcon, props)
}
