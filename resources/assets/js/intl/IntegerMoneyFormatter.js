import MoneyFormatter from './MoneyFormatter'

export default class IntegerMoneyFormatter extends MoneyFormatter {

    constructor(locale, currency) {
        super(locale, currency);
        this.formatCorrection = Math.pow(10, -1 * this.decimalPlaces);
        this.unformatCorrection = Math.pow(10, this.decimalPlaces);
    }

    format(value) {
        return super.format(value * this.formatCorrection);
    }

    unformat(value) {
        return super.unformat(value) * this.unformatCorrection;
    }

}