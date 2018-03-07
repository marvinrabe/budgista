import _ from 'lodash';

// transactions: [{ id, payee, amount, cleared, rrule, recurring, category: {id, name}, account_id }],
const state = {
    transactions: [],
    nextUrls: {}
};

export const getters = {
    findTransactionById: (state) => (id) => {
        return state.transactions.find(x => x.id === id)
    },
    isTransactionLoaded: (state) => (id) => {
        return state.transactions.find(x => x.id === id) !== undefined;
    },
    findTransactionsByAccountId: (state) => (id) => {
        let transactions = state.transactions.filter(x => x.account_id === id).slice();
        return _.sortBy(transactions, ['date', 'created_at', 'payee']).reverse();
    },
    getPayees(state) {
        return _.uniq(
            state.transactions
                .map(transaction => transaction.payee)
        );
    }
};

const actions = {

    loadTransaction({commit}, transaction_id) {
        return axios
            .get('/api/transactions/' + transaction_id)
            .then(({data}) => {
                if (data.category) {
                    commit('ADD_CATEGORY', data.data.category);
                }
                commit('ADD_TRANSACTION', data.data);
            });
    },

    loadTransactions({state, commit, dispatch}, account_id) {
        if (!(account_id in state.nextUrls)) {
            commit('NEXT_TRANSACTIONS', {
                account_id: account_id,
                url: '/api/accounts/' + account_id + '/transactions'
            });
            dispatch('loadMoreTransactions', account_id);
        }
    },

    loadMoreTransactions({state, commit}, account_id) {
        if (!state.nextUrls[account_id]) {
            return Promise.reject();
        }

        return axios
            .get(state.nextUrls[account_id])
            .then(({data}) => {
                commit('NEXT_TRANSACTIONS', {
                    account_id: account_id,
                    url: data.links.next
                });
                data.data.forEach(transaction => commit('ADD_TRANSACTION', transaction));
            });
    },

    createTransaction({commit, rootState}, transaction) {
        return axios
            .post('/api/transactions/', transaction)
            .then(({data}) => {
                commit('ADD_TRANSACTION', data.data);
                commit('ADD_BALANCE', data.data);
            });
    },

    updateTransaction({commit, getters}, transaction) {
        return axios
            .put('/api/transactions/' + transaction.id, transaction)
            .then(({data}) => {
                let oldTransaction = getters.findTransactionById(transaction.id);
                commit('REMOVE_BALANCE', oldTransaction);
                commit('ADD_TRANSACTION', data.data);
                commit('ADD_BALANCE', data.data);
            });
    },

    clearTransaction({commit}, transaction) {
        return axios
            .put('/api/transactions/' + transaction.id + '/clear')
            .then(({data}) => {
                commit('ADD_TRANSACTION', data.data);
            })
    },

    deleteTransaction({commit, getters}, transaction) {
        return axios
            .delete('/api/transactions/' + transaction.id)
            .then(() => {
                let oldTransaction = getters.findTransactionById(transaction.id);
                commit('REMOVE_BALANCE', oldTransaction);
                commit('REMOVE_TRANSACTION', transaction);
            });
    }

};

const mutations = {
    ADD_TRANSACTION(state, transaction) {
        state.transactions = state.transactions.filter(x => x.id !== transaction.id);
        // TODO unset category attribute if exists and set category_id
        state.transactions.push(transaction);
    },
    NEXT_TRANSACTIONS(state, {account_id, url}) {
        state.nextUrls[account_id] = url;
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