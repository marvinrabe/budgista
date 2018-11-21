import Vue from 'vue'
import VueI18n from 'vue-i18n'
import messages from '../lang/index'
import axios from 'axios'
import browserLocale from 'browser-locale'
import {languages} from '../config.js'
import MoneyFormat from './MoneyFormat'
import IntegerMoneyFormatter from './IntegerMoneyFormatter'
import _ from 'lodash'

Vue.use(VueI18n)

export const defaultLanguage = setLanguage(clientDefaultLanguage())

export const i18n = new VueI18n({
    locale: defaultLanguage,
    fallbackLocale: 'en',
    messages
})

export function clientDefaultLanguage() {
    return browserLocale().split('-').shift()
}

export function changeLanguage(languageCode) {
    i18n.locale = setLanguage(languageCode)
}

export function setLanguage(languageCode) {
    let validLanguageCode = sanitizeLanguage(languageCode)
    axios.defaults.headers.common['Accept-Language'] = validLanguageCode
    document.querySelector('html').setAttribute('lang', validLanguageCode)
    return validLanguageCode
}

export function sanitizeLanguage(languageCode) {
    if (languages.includes(languageCode)) {
        return languageCode
    }
    return 'en'
}

export const intl = {
    install(Vue) {

        Vue.component('money-format', MoneyFormat)

        let integerMoneyFormatter = _.memoize(
            (locale, currency) => {
                return new IntegerMoneyFormatter(locale, currency)
            },
            (locale, currency) => {
                return locale + '/' + currency
            })

        Vue.prototype.$moneyFormatter = function () {
            let currency = this.$store.state.user.currency
            let locale = this.$store.state.user.locale

            return integerMoneyFormatter(locale, currency)
        }

        let intlDateFormatter = _.memoize(
            (locale) => {
                return Intl.DateTimeFormat(locale, {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                })
            })

        Vue.prototype.$dateFormatter = function () {
            let locale = this.$store.state.user.locale

            return intlDateFormatter(locale)
        }
    }
}

Vue.use(intl)

export default i18n
