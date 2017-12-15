import accounts from '../../api/accounts'

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
            ({data}) => data.forEach(account => commit('ADD_ACCOUNT', account))
        )
    },

    createAccount({commit, rootState}, account) {
        accounts.create(
            account,
            ({data}) => commit('ADD_ACCOUNT', data)
        )
    },

    updateAccount({commit}, account) {
        accounts.update(
            account,
            ({data}) => commit('ADD_ACCOUNT', data)
        )
    },

    deleteAccount({commit}, account) {
        accounts.delete(
            account,
            () => commit('REMOVE_ACCOUNT', account)
        )
    },

    clearTransaction({commit}, transaction) {
        commit('CLEAR_ACCOUNT_BALANCE', {
            account_id: transaction.account_id,
            value: (transaction.cleared ? -1 : 1) * transaction.amount
        });
    }

};

// mutations
const mutations = {
    ADD_ACCOUNT(state, account) {
        state.accounts = state.accounts.filter(x => x.id !== account.id);
        state.accounts.push(account);
    },
    REMOVE_ACCOUNT(state, {id}) {
        state.accounts = state.accounts.filter(x => x.id !== id);
    },
    CLEAR_ACCOUNT_BALANCE(state, {account_id, value}) {
        let account = state.accounts.find(x => x.id === account_id);
        account.clearedBalance += value;
        account.unclearedBalance -= value;
    },
    ADD_BALANCE(state, transaction) {
        let account = state.accounts.find(x => x.id === transaction.account_id);

        if (new Date(transaction.date) > new Date()) {
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

        if (new Date(transaction.date) > new Date()) {
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