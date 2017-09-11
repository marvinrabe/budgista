import transactions from '../../api/transactions'
import * as types from '../mutation-types'

// initial state
// transactions: [{ id, payee, amount, cleared, rrule, recurring, category: {id, name}, account_id }]
const state = {
    transactions: []
};

// getters
const getters = {
    findTransactionsByAccountId: (state) => (id) => {
        return state.transactions.filter(x => x.account_id === id)
    }
};

// actions
const actions = {

    loadMoreTransactions({commit}, account_id) {
        transactions.getMoreTransactions(
            account_id,
            ({data}) => data.forEach(transaction => commit(types.ADD_TRANSACTION, transaction))
        )
    },

    createTransaction({commit, rootState}, transaction) {
        transactions.create(
            transaction,
            ({data}) => commit(types.ADD_TRANSACTION, data)
        )
    },

    updateTransaction({commit}, transaction) {
        transactions.update(
            transaction,
            ({data}) => commit(types.ADD_TRANSACTION, data)
        )
    },

    clearTransaction({commit}, transaction) {
        transactions.clear(
            transaction,
            ({data}) => commit(types.ADD_TRANSACTION, data)
        )
    },

    deleteTransaction({commit}, transaction) {
        transactions.delete(
            transaction,
            ({data}) => commit(types.REMOVE_TRANSACTION, transaction)
        )
    }

};

// mutations
const mutations = {
    [types.ADD_TRANSACTION](state, transaction) {
        state.transactions = state.transactions.filter(x => x.id !== transaction.id);
        state.transactions.push(transaction);
    },
    [types.REMOVE_TRANSACTION](state, {id}) {
        state.transactions = state.transactions.filter(x => x.id !== id);
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}