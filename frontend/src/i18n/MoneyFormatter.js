export default class MoneyFormatter {

    constructor(locale, currency) {
        this.intlFormatter = Intl.NumberFormat(locale, {style: 'currency', currency: currency});
        this.decimalPlaces = this.intlFormatter.resolvedOptions().minimumFractionDigits;

        let findCharacter = function (string, regex) {
            let results = string.match(regex);
            if (results && results.length) {
                return results[1];
            }
            return null;
        };

        let testString = this.intlFormatter.format(12345.6);
        this.thousandSeparator = findCharacter(testString, /12(.*)345/);
        this.decimalSeperator = findCharacter(testString, /345(.*)6/);
    }

    format(value) {
        return this.intlFormatter.format(value);
    }

    formatSimple(value) {
        return this.format(value).replace(/[^\d.,-]/g, '');
    }

    unformat(value) {
        value = String(value);

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