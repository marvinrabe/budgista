import {expect} from 'chai'
import moment from 'moment';
import {getters} from '@/store/modules/transactions'
import Transaction from '@/models/Transaction'

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

        expect(payees).to.deep.equal(['a', 'b']);
    });

    it('counts future transactions', () => {
        const mockGetter = {
            findTransactionsByAccountId: () => [
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

        expect(count).to.equal(1);
    });
});
