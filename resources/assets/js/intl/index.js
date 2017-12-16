import IntegerMoneyFormatter from './IntegerMoneyFormatter';

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

        Vue.prototype.$formatMoney = function (amount) {
            let currency = this.$store.state.currency;
            let locale = this.$store.state.locale;

            let formatter = new IntegerMoneyFormatter(locale, currency);
            return formatter.format(amount);
        }
    }
};

export default AppIntl;