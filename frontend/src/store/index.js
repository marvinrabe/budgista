import Vue from 'vue'
import Vuex from 'vuex'

import accounts from './modules/accounts'
import categories from './modules/categories'
import groups from './modules/groups'
import transactions from './modules/transactions'
import user from './modules/user'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export const store = new Vuex.Store({
    state: {
        loading: false
    },
    actions: {
        initialize({dispatch, commit}) {
            commit('IS_LOADING')
            commit('RESET')
            Promise
                .all([
                    dispatch('loadUser'),
                    dispatch('loadAccounts'),
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
        },
        IS_LOADING(state) {
            state.loading = true
        }
    },
    modules: {
        accounts,
        categories,
        groups,
        transactions,
        user
    },
    strict: debug
})

export default store
