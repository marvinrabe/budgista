import {library} from '@fortawesome/fontawesome-svg-core'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import {faTrashAlt} from '@fortawesome/free-regular-svg-icons'
import {faTimes, faPlus, faCog, faBars, faPencilAlt, faArrowsAltV} from '@fortawesome/free-solid-svg-icons'

library.add([
    faTrashAlt,
    faTimes,
    faPlus,
    faCog,
    faBars,
    faPencilAlt,
    faArrowsAltV
])

const FontAwesome = {
    install(Vue, options = {}) {
        Vue.component('font-awesome-icon', FontAwesomeIcon)
    }
}

export default FontAwesome
