import fontawesome from '@fortawesome/fontawesome';
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';

fontawesome.library.add([
    require('@fortawesome/fontawesome-free-regular/faEnvelope'),
    require('@fortawesome/fontawesome-free-regular/faTrashAlt'),
    require('@fortawesome/fontawesome-free-regular/faUserCircle'),
    require('@fortawesome/fontawesome-free-regular/faCalendarAlt'),
    require('@fortawesome/fontawesome-free-solid/faTimes'),
    require('@fortawesome/fontawesome-free-solid/faPlus'),
    require('@fortawesome/fontawesome-free-solid/faCog'),
    require('@fortawesome/fontawesome-free-solid/faSync'),
    require('@fortawesome/fontawesome-free-solid/faCheckCircle'),
    require('@fortawesome/fontawesome-free-solid/faChevronLeft'),
    require('@fortawesome/fontawesome-free-solid/faChevronRight'),
    require('@fortawesome/fontawesome-free-solid/faBars'),
    require('@fortawesome/fontawesome-free-solid/faShieldAlt'),
    require('@fortawesome/fontawesome-free-solid/faEye'),
    require('@fortawesome/fontawesome-free-solid/faEyeSlash'),
    require('@fortawesome/fontawesome-free-solid/faSpinner'),
    require('@fortawesome/fontawesome-free-solid/faPencilAlt')
]);

const FontAwesome = {
    install(Vue, options = {}) {
        Vue.component('font-awesome-icon', FontAwesomeIcon);
    }
};

export default FontAwesome;