import {shallow, createLocalVue} from 'vue-test-utils';
import expect from 'expect';
import { getters } from '../../../resources/assets/js/store/modules/transactions'
import Vuex from 'vuex';

const localVue = createLocalVue();

localVue.use(Vuex);

describe('DateFormat', () => {
    it.only('returns a payee list', () => {
        const state = {
            transactions: [
                {
                    'payee': 'a'
                },
                {
                    'payee': 'b'
                },
                {
                    'payee': 'a'
                },
                {
                    'payee': ''
                }
            ]
        };

        const payees = getters.getPayees(state);

        expect(payees).toEqual(['a', 'b']);
    });
});
