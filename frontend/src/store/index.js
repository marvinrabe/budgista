import Vue from 'vue'
import Vuex from 'vuex'

import accounts from './modules/accounts'
import budgets from './modules/budgets'
import categories from './modules/categories'
import groups from './modules/groups'
import transactions from './modules/transactions'
import statistics from './modules/statistics'
import user from './modules/user'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export const store = new Vuex.Store({
    state: {
        loading: true
    },
    actions: {
        initialize({dispatch, commit}) {
            Promise
                .all([
                    dispatch('loadUser'),
                    dispatch('loadCategories'),
                    dispatch('loadGroups')
                ])
                .then(() => {
                    commit('HAS_LOADED')
                })
        }
    },
    mutations: {
        HAS_LOADED(state) {
            state.loading = false
        }
    },
    modules: {
        accounts,
        budgets,
        categories,
        groups,
        transactions,
        statistics,
        user
    },
    strict: debug
})

export default store
