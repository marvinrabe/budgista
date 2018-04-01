import {mount} from '@vue/test-utils';
import expect from 'expect';
import AppButton from '@/components/form/AppButton.vue';

describe('AppButton', () => {

    it('has a default primary style', () => {
        const wrapper = mount(AppButton, {
            propsData: {label: 'Save'}
        });

        expect(wrapper.html()).toContain('btn-primary');
    });

    it('has a secondary style', () => {
        const wrapper = mount(AppButton, {
            propsData: {label: 'Save', type: 'secondary'}
        });

        expect(wrapper.html()).toContain('btn-light');
    });

    it('has a tertiary style', () => {
        const wrapper = mount(AppButton, {
            propsData: {label: 'Save', type: 'tertiary'}
        });

        expect(wrapper.html()).toContain('btn-text-light');
    });

    it('hides spinner by default', () => {
        const wrapper = mount(AppButton, {
            propsData: {label: 'Save'}
        });

        expect(wrapper.find('.fa-spinner').exists()).toBe(false);
    });

    it('shows spinner if busy', () => {
        const wrapper = mount(AppButton, {
            propsData: {label: 'Save', busy: true}
        });

        expect(wrapper.find('.fa-spinner').exists()).toBe(true);
    });

});
