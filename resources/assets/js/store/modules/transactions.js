import transactions from '../../api/transactions'

// initial state
// transactions: [{ id, payee, amount, cleared, rrule, recurring, category: {id, name}, account_id }],
// loaded: [account_id]
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
                    if (data.category) {
                        commit('ADD_CATEGORY', data.category);
                    }
                    commit('ADD_TRANSACTION', data);
                    resolve(data)
                },
                () => reject()
            );
        })
    },

    loadTransactions({state, commit, dispatch}, account_id) {
        if (state.loaded.indexOf(account_id) === -1) {
            dispatch('loadMoreTransactions', account_id);
            commit('MARK_LOADED', account_id)
        }
    },

    loadMoreTransactions({commit}, account_id) {
        return new Promise((resolve, reject) => {
            transactions.getMoreTransactions(
                account_id,
                ({data}) => {
                    if (data) {
                        data.forEach(transaction => commit('ADD_TRANSACTION', transaction));
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
                commit('ADD_TRANSACTION', data);
                commit('ADD_BALANCE', data);
            }
        )
    },

    updateTransaction({commit, getters}, transaction) {
        transactions.update(
            transaction,
            ({data}) => {
                let oldTransaction = getters.findTransactionById(transaction.id);
                commit('REMOVE_BALANCE', oldTransaction);
                commit('ADD_TRANSACTION', data);
                commit('ADD_BALANCE', data);
            }
        )
    },

    clearTransaction({commit}, transaction) {
        transactions.clear(
            transaction,
            ({data}) => commit('ADD_TRANSACTION', data)
        )
    },

    deleteTransaction({commit, getters}, transaction) {
        transactions.delete(
            transaction,
            ({data}) => {
                let oldTransaction = getters.findTransactionById(transaction.id);
                commit('REMOVE_BALANCE', oldTransaction);
                commit('REMOVE_TRANSACTION', transaction);
            }
        )
    }

};

// mutations
const mutations = {
    ADD_TRANSACTION(state, transaction) {
        state.transactions = state.transactions.filter(x => x.id !== transaction.id);
        // TODO unset category attribute if exists and set category_id
        state.transactions.push(transaction);
    },
    MARK_LOADED(state, account_id) {
        state.loaded.push(account_id);
    },
    REMOVE_TRANSACTION(state, {id}) {
        state.transactions = state.transactions.filter(x => x.id !== id);
    },
    TRANSFER_CATEGORY(state, {from, to}) {
        state.transactions
            .filter(x => _.get(x, 'category.id') === from.id)
            .forEach(transaction => transaction.category = to);
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}