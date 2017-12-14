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
            ({data}) => data.forEach(account => commit(types.ADD_ACCOUNT, account))
        )
    },

    createAccount({commit, rootState}, account) {
        accounts.create(
            account,
            ({data}) => commit(types.ADD_ACCOUNT, data)
        )
    },

    updateAccount({commit}, account) {
        accounts.update(
            account,
            ({data}) => commit(types.ADD_ACCOUNT, data)
        )
    },

    deleteAccount({commit}, account) {
        accounts.delete(
            account,
            () => commit(types.REMOVE_ACCOUNT, account)
        )
    },

    clearTransaction({commit}, transaction) {
        if(transaction.cleared) {
            commit(types.CLEAR_ACCOUNT_BALANCE, {
                account_id: transaction.account_id,
                value: -transaction.amount
            });
        } else {
            commit(types.CLEAR_ACCOUNT_BALANCE, {
                account_id: transaction.account_id,
                value: transaction.amount
            });
        }
    },

};

// mutations
const mutations = {
    [types.ADD_ACCOUNT](state, account) {
        state.accounts = state.accounts.filter(x => x.id !== account.id);
        state.accounts.push(account);
    },
    [types.REMOVE_ACCOUNT](state, {id}) {
        state.accounts = state.accounts.filter(x => x.id !== id);
    },
    [types.CLEAR_ACCOUNT_BALANCE](state, {account_id, value}) {
        let account = state.accounts.find(x => x.id === account_id);
        account.clearedBalance += value;
        account.unclearedBalance -= value;
    },
    [types.ADD_BALANCE](state, transaction) {
        let account = state.accounts.find(x => x.id === transaction.account_id);

        if(new Date(transaction.date) > new Date()) {
            return;
        }

        if(transaction.cleared) {
            account.clearedBalance += transaction.amount;
        } else {
            account.unclearedBalance += transaction.amount;
        }
        account.workingBalance += transaction.amount;
    },
    [types.REMOVE_BALANCE](state, transaction) {
        let account = state.accounts.find(x => x.id === transaction.account_id);

        if(new Date(transaction.date) > new Date()) {
            return;
        }

        if(transaction.cleared) {
            account.clearedBalance -= transaction.amount;
        } else {
            account.unclearedBalance -= transaction.amount;
        }
        account.workingBalance -= transaction.amount;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}