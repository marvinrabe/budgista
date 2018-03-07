import expect from 'expect';
import {getters} from '../../../resources/assets/js/store/modules/transactions'

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
});
