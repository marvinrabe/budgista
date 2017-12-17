import fontawesome from '@fortawesome/fontawesome';
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';

fontawesome.library.add([
    require('@fortawesome/fontawesome-free-regular/faEnvelope'),
    require('@fortawesome/fontawesome-free-regular/faTrashAlt'),
    require('@fortawesome/fontawesome-free-solid/faTimes'),
    require('@fortawesome/fontawesome-free-solid/faPlus'),
    require('@fortawesome/fontawesome-free-solid/faPencilAlt'),
    require('@fortawesome/fontawesome-free-solid/faSync'),
    require('@fortawesome/fontawesome-free-solid/faCheck'),
    require('@fortawesome/fontawesome-free-solid/faChevronLeft'),
    require('@fortawesome/fontawesome-free-solid/faChevronRight'),
    require('@fortawesome/fontawesome-free-solid/faBars')
]);

const FontAwesome = {
    install(Vue, options = {}) {
        Vue.component('font-awesome-icon', FontAwesomeIcon);
    }
};

export default FontAwesome;