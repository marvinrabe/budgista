import {shallow, createLocalVue} from 'vue-test-utils';
import expect from 'expect';
import MoneyFormat from '../../../resources/assets/js/intl/MoneyFormat.vue';
import AppIntl from '../../../resources/assets/js/intl';
import Vuex from 'vuex';

const localVue = createLocalVue();

localVue.use(Vuex);
localVue.use(AppIntl);

describe('MoneyFormat', () => {
    it('returns a formatted currency value', () => {
        let store = new Vuex.Store({
            state: {
                locale: 'de',
                currency: 'EUR'
            }
        });

        let wrapper = shallow(MoneyFormat, {
            store, localVue,
            propsData: {
                value: '123456'
            }
        });

        expect(wrapper.html()).toContain('1.234,56&nbsp;€');
    });
});
