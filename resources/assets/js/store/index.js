import Vue from 'vue'
import Vuex from 'vuex'

import accounts from './modules/accounts'
import categories from './modules/categories'
import transactions from './modules/transactions'
import user from './modules/user'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export const store = new Vuex.Store({
    state: {
        loading: false
    },
    actions: {
        initialize({dispatch, commit, state}) {
            commit('IS_LOADING')
            commit('RESET')
            Promise
                .all([
                    dispatch('loadUser'),
                    dispatch('loadAccounts'),
                    dispatch('loadCategories')
                ])
                .then(() => {
                    commit('HAS_LOADED')
                })
        }
    },
    mutations: {
        HAS_LOADED(state) {
            state.loading = false
        },
        IS_LOADING(state) {
            state.loading = true
        }
    },
    modules: {
        accounts,
        categories,
        transactions,
        user
    },
    strict: debug
})

export default store