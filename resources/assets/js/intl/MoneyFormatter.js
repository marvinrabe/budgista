export default class MoneyFormatter {
    constructor(locale, currency) {
        this.intlFormatter = Intl.NumberFormat(locale, {style: 'currency', currency: currency});
        this.decimalPlaces = this.intlFormatter.resolvedOptions().minimumFractionDigits;
        this.thousandSeparator = this.intlFormatter.format(12345.6).match(/12(.*)345/)[1];
        this.decimalSeperator = this.intlFormatter.format(12345.6).match(/345(.*)6/)[1];
    }

    format(value) {
        return this.intlFormatter.format(value);
    }

    unformat(value) {
        // remove thousand seperator
        if (this.thousandSeparator) {
            value = value.replace(this.thousandSeparator, '')
        }

        // remove non-numeric signs except - , .
        value = value.replace(/[^\d.,-]/g, '');

        // remove decimal seperator
        if (this.decimalSeperator) {
            value = value.replace(this.decimalSeperator, '.');
        }

        // return real number
        return Number(value);
    }
}