import {shallowMount, createLocalVue} from '@vue/test-utils'
import Vuex from 'vuex'
import {assert} from 'chai'
import sinon from 'sinon'
import AppForm from '@/components/form/AppForm.vue'
//import Transaction from '@/models/Transaction'
//import TransactionForm from '@/components/transactions/TransactionForm.vue'

const localVue = createLocalVue()

localVue.use(Vuex)

describe.skip('TransactionForm', () => {
    let actions
    let store

    beforeEach(() => {
        actions = {
            saveTransaction: sinon.stub()
        }

        store = new Vuex.Store({actions})
    })

    it('dispatches cancel event', () => {
        const wrapper = shallowMount(TransactionForm, {store, localVue})

        const submitButton = wrapper.find('[rel=\'cancel\']')
        submitButton.trigger('click')

        assert.exists(wrapper.emitted('cancel'), 'cancel event dispatched')
    })

    it('dispatches save event', () => {
        const wrapper = shallowMount(TransactionForm, {store, localVue})

        wrapper.find(AppForm).trigger('submit')

        assert.exists(wrapper.emitted('save'), 'save event dispatched')
    })

    it('returns transaction with save event', () => {
        const wrapper = shallowMount(TransactionForm, {store, localVue})

        wrapper.find(AppForm).trigger('submit')

        assert.instanceOf(wrapper.emitted().save[0], Transaction)
    })

})
