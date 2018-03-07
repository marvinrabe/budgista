import Vue from 'vue'
import Vuex from 'vuex'

import accounts from './modules/accounts'
import categories from './modules/categories'
import transactions from './modules/transactions'
import user from './modules/user'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    state: {
        loading: true
    },
    actions: {
        initialize({dispatch, commit}) {
            Promise
                .all([
                    dispatch('loadUser'),
                    dispatch('loadAccounts'),
                    dispatch('loadCategories')
                ])
                .then(() => {
                    commit('IS_LOADED');
                })
        }
    },
    mutations: {
        IS_LOADED(state) {
            state.loading = false;
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