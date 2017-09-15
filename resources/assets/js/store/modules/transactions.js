import transactions from '../../api/transactions'
import * as types from '../mutation-types'

// initial state
// transactions: [{ id, payee, amount, cleared, rrule, recurring, category: {id, name}, account_id }],
// loaded: []
const state = {
    transactions: [],
    loaded: [],
};

// getters
const getters = {
    findTransactionById: (state) => (id) => {
        return state.transactions.find(x => x.id === id)
    },
    isTransactionLoaded: (state) => (id) => {
        return state.transactions.find(x => x.id === id) !== undefined;
    },
    findTransactionsByAccountId: (state) => (id) => {
        let transactions = state.transactions.filter(x => x.account_id === id).slice();
        return _.sortBy(transactions, ['date', 'created_at', 'payee']).reverse();
    }
};

// actions
const actions = {

    getTransaction({commit}, transaction_id) {
        return new Promise((resolve, reject) => {
            transactions.get(
                transaction_id,
                ({data}) => {
                    if(data.category) {
                        commit(types.ADD_CATEGORY, data.category);
                    }
                    commit(types.ADD_TRANSACTION, data);
                    resolve(data)
                },
                () => reject()
            );
        })
    },

    loadTransactions({state, commit, dispatch}, account_id) {
        if (state.loaded.indexOf(account_id) === -1) {
            dispatch('loadMoreTransactions', account_id);
            commit(types.MARK_LOADED, account_id)
        }
    },

    loadMoreTransactions({commit}, account_id) {
        return new Promise((resolve, reject) => {
            transactions.getMoreTransactions(
                account_id,
                ({data}) => {
                    if(data) {
                        data.forEach(transaction => commit(types.ADD_TRANSACTION, transaction));
                        resolve();
                    } else {
                        reject();
                    }
                })
        });
    },

    createTransaction({commit, rootState}, transaction) {
        transactions.create(
            transaction,
            ({data}) => {
                commit(types.ADD_TRANSACTION, data);
                commit(types.ADD_BALANCE, data);
            }
        )
    },

    updateTransaction({commit, getters}, transaction) {
        transactions.update(
            transaction,
            ({data}) => {
                let oldTransaction = getters.findTransactionById(transaction.id);
                commit(types.REMOVE_BALANCE, oldTransaction);
                commit(types.ADD_TRANSACTION, data);
                commit(types.ADD_BALANCE, data);
            }
        )
    },

    clearTransaction({commit}, transaction) {
        transactions.clear(
            transaction,
            ({data}) => commit(types.ADD_TRANSACTION, data)
        )
    },

    deleteTransaction({commit, getters}, transaction) {
        transactions.delete(
            transaction,
            ({data}) => {
                let oldTransaction = getters.findTransactionById(transaction.id);
                commit(types.REMOVE_BALANCE, oldTransaction);
                commit(types.REMOVE_TRANSACTION, transaction);
            }
        )
    }

};

// mutations
const mutations = {
    [types.ADD_TRANSACTION](state, transaction) {
        state.transactions = state.transactions.filter(x => x.id !== transaction.id);
        // TODO unset category attribute if exists and set category_id
        state.transactions.push(transaction);
    },
    [types.MARK_LOADED](state, account_id) {
        state.loaded.push(account_id);
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