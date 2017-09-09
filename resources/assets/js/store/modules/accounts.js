import accounts from '../../api/accounts'
import * as types from '../mutation-types'

// initial state
// accounts: [{ id, name, workingBalance, clearedBalance, unclearedBalance }]
const state = {
    accounts: []
};

// getters
const getters = {
    sortedAccounts(state) {
        return state.accounts.slice().sort(function (a, b) {
            return a.name.localeCompare(b.name);
        })
    },
    findAccountById: (state) => (id) => {
        return state.accounts.find(x => x.id === id)
    }
};

// actions
const actions = {

    loadAccounts({commit, rootState}) {
        accounts.getAll(
            rootState.budget.id,
            ({data}) => data.forEach(account => commit(types.ADD_ACCOUNT, account))
        )
    },

    createAccount({commit, rootState}, account) {
        account.budget = rootState.budget.id;

        accounts.create(
            account,
            ({data}) => commit(types.ADD_ACCOUNT, data)
        )
    },

    updateAccount({commit}, account) {
        accounts.update(
            account,
            ({data}) => commit(types.UPDATE_ACCOUNT, data)
        )
    },

    deleteAccount({commit}, account) {
        accounts.delete(
            account,
            () => commit(types.REMOVE_ACCOUNT, account.id)
        )
    }

};

// mutations
const mutations = {
    [types.ADD_ACCOUNT](state, account) {
        state.accounts.push(account);
    },
    [types.UPDATE_ACCOUNT](state, account) {
        state.accounts.find(x => x.id === account.id).name = account.name;
    },
    [types.REMOVE_ACCOUNT](state, account_id) {
        state.accounts = state.accounts.filter(x => x.id !== account_id);
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}