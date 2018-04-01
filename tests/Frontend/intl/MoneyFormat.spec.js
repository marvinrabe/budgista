import {shallow} from '@vue/test-utils';
import expect from 'expect';
import MoneyFormat from '@/i18n/MoneyFormat.vue';
import IntegerMoneyFormatter from '@/i18n/IntegerMoneyFormatter';

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
