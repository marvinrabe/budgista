import Vue from 'vue'
import Vuex from 'vuex'
import {state, mutations} from './mutations'
import * as actions from './actions'
import * as getters from './getters'
import accounts from './modules/accounts'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    state,
    mutations,
    actions,
    //getters,
    modules: {
        accounts
    },
    strict: debug
})