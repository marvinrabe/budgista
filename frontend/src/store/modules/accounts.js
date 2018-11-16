import axios from 'axios'

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
    spendingAccounts(state) {
        return getters.sortedAccounts(state).filter(x => x.tracking === false);
    },
    trackingAccounts(state) {
        return getters.sortedAccounts(state).filter(x => x.tracking === true);
    },
    findAccountById: (state) => (id) => {
        return state.accounts.find(x => x.id === id)
    }
};

// actions
const actions = {

    loadAccounts({commit}) {
        return axios
            .get('/accounts')
            .then(({data}) => {
                let accounts = data.data;
                accounts.forEach(account => commit('ADD_ACCOUNT', account))
            });
    },

    createAccount({commit}, account) {
        return axios
            .post('/accounts/', account)
            .then(({data}) => {
                commit('ADD_ACCOUNT', data.data);
            });
    },

    updateAccount({commit}, account) {
        return axios
            .put('/accounts/' + account.id, {
                'name': account.name,
                'tracking': account.tracking,
                'icon': account.icon
            })
            .then(({data}) => {
                commit('ADD_ACCOUNT', data.data);
            });
    },

    deleteAccount({commit}, account) {
        return axios
            .delete('/accounts/' + account.id)
            .then(({data}) => {
                commit('REMOVE_ACCOUNT', account);
            });
    }

};

// mutations
const mutations = {
    RESET(state) {
        state.accounts = []
    },
    ADD_ACCOUNT(state, account) {
        state.accounts = state.accounts.filter(x => x.id !== account.id);
        state.accounts.push(account);
    },
    REMOVE_ACCOUNT(state, {id}) {
        state.accounts = state.accounts.filter(x => x.id !== id);
    },
    CLEAR_ACCOUNT_BALANCE(state, {account_id, amount, cleared}) {
        const account = state.accounts.find(x => x.id === account_id);
        const value = (cleared ? 1 : -1) * amount;
        account.clearedBalance += value;
        account.unclearedBalance -= value;
    },
    ADD_BALANCE(state, transaction) {
        let account = state.accounts.find(x => x.id === transaction.account_id);

        if (transaction.isFuture()) {
            return;
        }

        if (transaction.cleared) {
            account.clearedBalance += transaction.amount;
        } else {
            account.unclearedBalance += transaction.amount;
        }
        account.workingBalance += transaction.amount;
    },
    REMOVE_BALANCE(state, transaction) {
        let account = state.accounts.find(x => x.id === transaction.account_id);

        if (transaction.isFuture()) {
            return;
        }

        if (transaction.cleared) {
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
