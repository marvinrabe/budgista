import moment from 'moment'

//{ id, date, payee, amount, cleared, rrule, recurring, category: {id, name}, account_id }
export default class Transaction {

    constructor() {
        this.date = moment()
        this.cleared = false
    }

    clear() {
        this.cleared = !this.cleared
    }

    isFuture() {
        return moment(this.date).isAfter()
    }

}
