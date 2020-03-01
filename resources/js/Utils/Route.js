import {Inertia} from '@inertiajs/inertia'
import _ from 'lodash'

export function budgetRoute (base, category = null) {
  if (category) {
    return base + '/categories/' + category.id
  }
  return base
}

export function transactionRoute (page) {
  let params = new URLSearchParams()

  let referer = _.get(Inertia, 'page.url', undefined)
  if (referer && !referer.startsWith('/transactions/create')) {
    params.append('referer', referer)
  }

  let category = _.get(page, 'category.id', undefined)
  if (category) {
    params.append('category', category)
  }

  let account = _.get(page, 'account.id', undefined)
  if (account) {
    params.append('account', account)
  }

  return '/transactions/create?' + params.toString()
}
