import Vue from 'vue'
import {library} from '@fortawesome/fontawesome-svg-core'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import {faPlus, faCog, faPencilAlt, faArrowsAltV} from '@fortawesome/free-solid-svg-icons'

library.add([
    faPlus,
    faCog,
    faPencilAlt,
    faArrowsAltV
])

const FontAwesome = {
    install(Vue) {
        Vue.component('font-awesome-icon', FontAwesomeIcon)
    }
}

Vue.use(FontAwesome)

export default FontAwesome
