import {shallow} from '@vue/test-utils';
import expect from 'expect';
import MoneyFormat from '../../../resources/assets/js/intl/MoneyFormat.vue';
import IntegerMoneyFormatter from '../../../resources/assets/js/intl/IntegerMoneyFormatter';

describe('MoneyFormat', () => {

    it('returns a formatted currency value', () => {
        const $moneyFormatter = () => new IntegerMoneyFormatter('de', 'EUR');
        const wrapper = shallow(MoneyFormat, {
            propsData: {value: '123456'},
            mocks: {$moneyFormatter}
        });

        expect(wrapper.html()).toContain('1.234,56&nbsp;€');
    });

});
