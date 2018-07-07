import Vue from 'vue'
import VueI18n from 'vue-i18n'
import messages from '../lang/index'
import axios from 'axios'
import IntegerMoneyFormatter from './IntegerMoneyFormatter';
import _ from 'lodash';

Vue.use(VueI18n);

export const i18n = new VueI18n({
    locale: document.querySelector('html').getAttribute('lang') || 'en',
    fallbackLocale: 'en',
    messages
});

export const intl = {
    install(Vue, options = {}) {

        Vue.component(
            'money-format',
            require('./MoneyFormat.vue')
        );

        Vue.component(
            'date-input',
            require('./DateInput.vue')
        );

        let integerMoneyFormatter = _.memoize(
            (locale, currency) => {
                return new IntegerMoneyFormatter(locale, currency);
            },
            (locale, currency) => {
                return locale + '/' + currency;
            });

        Vue.prototype.$moneyFormatter = function () {
            let currency = this.$store.state.user.currency;
            let locale = this.$store.state.user.locale;

            return integerMoneyFormatter(locale, currency);
        };

        let intlDateFormatter = _.memoize(
            (locale) => {
                return Intl.DateTimeFormat(locale, {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                });
            });

        Vue.prototype.$dateFormatter = function () {
            let locale = this.$store.state.user.locale;

            return intlDateFormatter(locale);
        };
    }
};

Vue.use(intl);

export function setLanguage(lang) {
    i18n.locale = lang;
    axios.defaults.headers.common['Accept-Language'] = lang;
    document.querySelector('html').setAttribute('lang', lang);
    return lang;
}