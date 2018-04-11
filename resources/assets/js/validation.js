import Vue from 'vue'
import VeeValidate from 'vee-validate'
import {i18n} from './i18n'

Vue.use(VeeValidate, {
    validity: true,
    classes: true,
    classNames: {
        invalid: 'is-invalid'
    },
    i18n: i18n
})