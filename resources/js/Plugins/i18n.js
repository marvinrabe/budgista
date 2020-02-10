import axios from 'axios'
import Vue from 'vue'
import VueI18n from 'vue-i18n'
import messages from '../lang'

Vue.use(VueI18n)

export const defaultLanguage = setLanguage(clientDefaultLanguage())

export const fallbackLocale = 'en'

export const fallbackCurrency = 'eur'

export const i18n = new VueI18n({
  locale: defaultLanguage,
  fallbackLocale,
  messages
})

export function clientDefaultLanguage () {
  return document.querySelector('html').getAttribute('lang')
}

export function changeLanguage (languageCode) {
  i18n.locale = setLanguage(languageCode)
}

export function setLanguage (languageCode) {
  axios.defaults.headers.common['Accept-Language'] = languageCode
  document.querySelector('html').setAttribute('lang', languageCode)
  localStorage.setItem('language', languageCode)
  return languageCode
}

export default i18n
