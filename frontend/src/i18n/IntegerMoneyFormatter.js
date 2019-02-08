import * as Dinero from 'dinero.js'

export default class IntegerMoneyFormatter {

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

  unformat (value) {
    let seperator = value.indexOf(this.decimalSeparator())

    let number = [value]
    if (seperator !== -1) {
      number = [
        value.slice(0, seperator),
        value.slice(seperator + 1)
      ]
    }
    number = number.map(v => v.replace(/\D/g, ''))
    if (number[1]) {
      number[1] = number[1].slice(0, 2).padEnd(2, '0')
    } else {
      number[1] = '00'
    }
    console.log(number)
    return number.join('')
  }

  decimalSeparator () {
    const numberWithDecimalSeparator = 1.1
    return Intl.NumberFormat(this.locale)
      .formatToParts(numberWithDecimalSeparator)
      .find(part => part.type === 'decimal')
      .value
  }

}
