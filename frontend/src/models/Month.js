import moment from 'moment'
import {i18n} from '../i18n'

export default class Month {

    constructor(year, month) {
        this.year = year
        this.month = month
    }

    static current() {
        let today = moment()
        return new Month(today.year(), today.month() + 1)
    }

    static fromString(string) {
        let month = moment(string + '-01')
        return new Month(month.year(), month.month() + 1)
    }

    getDate() {
        return moment().year(this.year).month(this.month - 1)
    }

    toString() {
        return this.getDate().format('YYYY-MM')
    }

    previous() {
        let previous = this.getDate().subtract(1, 'months')
        return new Month(previous.year(), previous.month() + 1)
    }

    next() {
        let next = this.getDate().add(1, 'months')
        return new Month(next.year(), next.month() + 1)
    }

    format() {
        return i18n.messages[i18n.locale].month[this.month] + ' ' + this.year
    }
};
