import {mount} from '@vue/test-utils'
import {assert} from 'chai'
import AppForm from '@/components/form/AppForm.vue'
import {Validator} from 'vee-validate'

const validator = new Validator({}, {})

describe('AppForm', () => {

    // See Bug: https://github.com/vuejs/vue-test-utils/issues/1030
    it.skip('is submitted when button is pressed', () => {
        const wrapper = mount(AppForm, {
            slots: {
                actions: '<button type="submit">Submit</button>'
            },
            provide: () => ({
                $validator: validator
            })
        })

        wrapper.find('button').trigger('click')

        assert.exists(wrapper.emitted().submit, 'submit event dispatched')
    })

})
