import Vue from 'vue'
import Vuex from 'vuex'
import {state, mutations} from './mutations'
import * as actions from './actions'
import * as getters from './getters'
import accounts from './modules/accounts'
import categories from './modules/categories'
import transactions from './modules/transactions'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    state,
    mutations,
    actions,
    //getters,
    modules: {
        accounts,
        categories,
        transactions
    },
    strict: debug
})