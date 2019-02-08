import AppMoney from '@/components/AppMoney.vue'
import { shallow } from '@vue/test-utils'
import { expect } from 'chai'
import MoneyFormatter from '../../../src/i18n/MoneyFormatter'

describe('AppMoney', () => {

  it('returns a formatted currency value', () => {
    const $moneyFormatter = () => new MoneyFormatter('de', 'EUR')
    const wrapper = shallow(AppMoney, {
      propsData: { value: '123456' },
      mocks: { $moneyFormatter }
    })

    expect(wrapper.html()).to.contain('1.234,56&nbsp;€')
  })

})
