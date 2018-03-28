import {shallow, createLocalVue} from '@vue/test-utils';
import expect from 'expect';
import DateFormat from '../../../resources/assets/js/intl/DateFormat.vue';
import Vuex from 'vuex';

const localVue = createLocalVue();

localVue.use(Vuex);

describe('DateFormat', () => {
    it('returns a formatted date', () => {
        let store = new Vuex.Store({
            state: {
                locale: 'de'
            }
        });

        let wrapper = shallow(DateFormat, {
            store, localVue,
            propsData: {
                value: '1991-03-31',
                options: {year: 'numeric', month: '2-digit', day: '2-digit'}
            }
        });

        expect(wrapper.html()).toContain('31.03.1991');
    });
});
