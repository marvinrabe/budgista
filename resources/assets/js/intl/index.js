import IntegerMoneyFormatter from './IntegerMoneyFormatter';
import _ from 'lodash';

const AppIntl = {
    install(Vue, options = {}) {

        Vue.component(
            'money-format',
            require('./MoneyFormat.vue')
        );

        Vue.component(
            'money-input',
            require('./MoneyInput.vue')
        );

        Vue.component(
            'date-format',
            require('./DateFormat.vue')
        );

        Vue.component(
            'date-input',
            require('./DateInput.vue')
        );

        Vue.prototype.$moneyFormatter = _.memoize(function () {
            let currency = this.$store.state.user.currency;
            let locale = this.$store.state.user.locale;

            return new IntegerMoneyFormatter(locale, currency);
        });
    }
};

export default AppIntl;