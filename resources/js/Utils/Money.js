import Dinero from 'dinero.js'

export const mixin = {
  computed: {
    moneyFormat () {
      if (this.$page.user) {
        return new Formatter(
          this.$page.user.locale,
          this.$page.user.currency
        )
      }
      return new Formatter('en', 'USD')
    }
  }
}

export default class Formatter {
  constructor (locale, currency) {
    this.locale = locale
    this.currency = currency
  }

  format (value) {
    return Dinero({ amount: parseInt(value), currency: this.currency })
      .setLocale(this.locale)
      .toFormat('$0,0.00')
  }

  formatSimple (value) {
    return Dinero({ amount: parseInt(value), currency: this.currency })
      .setLocale(this.locale)
      .toFormat('0,0.00')
  }

  unformat (value, allowNegative = false) {
    let separator = value.indexOf(this.decimalSeparator())

    let numberParts = [value]
    if (separator !== -1) {
      numberParts = [
        value.slice(0, separator),
        value.slice(separator + 1)
      ]
    }

    const regex = allowNegative ? /[^-\d]/g : /\D/g
    numberParts = numberParts.map(v => v.replace(regex, ''))

    if (numberParts[1]) {
      numberParts[1] = numberParts[1].slice(0, 2).padEnd(2, '0')
    } else {
      numberParts[1] = '00'
    }
    return Number(numberParts.join(''))
  }

  decimalSeparator () {
    const numberWithDecimalSeparator = 1.1
    return Intl.NumberFormat(this.locale)
      .formatToParts(numberWithDecimalSeparator)
      .find(part => part.type === 'decimal')
      .value
  }
}
