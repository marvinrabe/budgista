import dayjs from 'dayjs'
import { i18n } from '@/Plugins/i18n'

export default class Month {
  constructor (year, month) {
    this.year = year
    this.month = month
  }

  static current () {
    let today = dayjs()
    return new Month(today.year(), today.month() + 1)
  }

  static fromString (value) {
    let month = dayjs(value + '-01')
    return new Month(month.year(), month.month() + 1)
  }

  getDate () {
    return dayjs().year(this.year).month(this.month - 1)
  }

  toString () {
    return this.getDate().format('YYYY-MM')
  }

  previous () {
    let previous = this.getDate().subtract(1, 'months')
    return new Month(previous.year(), previous.month() + 1)
  }

  next () {
    let next = this.getDate().add(1, 'months')
    return new Month(next.year(), next.month() + 1)
  }

  format () {
    return i18n.t(`month.${this.month}`) + ' ' + this.year
  }
}
