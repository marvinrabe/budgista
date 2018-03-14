import expect from 'expect';
import moment from 'moment';
import {getters} from '../../../resources/assets/js/store/modules/transactions'
import Transaction from '../../../resources/assets/js/models/Transaction'

describe('Transactions Store', () => {
    it('returns a payee list', () => {
        const state = {
            transactions: [
                {'payee': 'a'},
                {'payee': 'b'},
                {'payee': 'a'}
            ]
        };

        const payees = getters.getPayees(state);

        expect(payees).toEqual(['a', 'b']);
    });

    it('counts future transactions', () => {
        const mockGetter = {
            findTransactionsByAccountId: (id) => [
                Object.assign(new Transaction, {
                    'account_id': '5532ca25-dc33-468b-8b75-37cfe6ba81e0',
                    'date': moment().add(1, 'days').format('YYYY-MM-DD')
                }),
                Object.assign(new Transaction, {
                    'account_id': '5532ca25-dc33-468b-8b75-37cfe6ba81e0',
                    'date': moment().format('YYYY-MM-DD')
                })
            ]
        };

        const account = {id: '5532ca25-dc33-468b-8b75-37cfe6ba81e0'};

        const count = getters.countFutureTransactions({}, mockGetter)(account);

        expect(count).toEqual(1);
    });
});
