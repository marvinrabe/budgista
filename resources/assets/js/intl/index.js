
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

        Vue.prototype.$formatMoney = function (amount) {
            let currency = this.$store.state.currency;
            let locale = this.$store.state.locale;

            let formatter = Intl.NumberFormat(locale, {style: 'currency', currency: currency});
            let decimalPlacesCorrection = Math.pow(10, -1 * formatter.resolvedOptions().minimumFractionDigits);

            return formatter.format(amount * decimalPlacesCorrection);
        }
    }
};

export default AppIntl;