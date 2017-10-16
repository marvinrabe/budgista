import * as types from './mutation-types'
import budget from '../api/budget'

export const initialize = ({ dispatch, commit }) => {
    dispatch('loadBudget');
};

export const loadBudget = ({ commit }) => {
    return new Promise((resolve, reject) => {
        budget.get(
            ({data, accounts, categories}) => {
                commit(types.LOAD_BUDGET, data);
                accounts.forEach(account => commit(types.ADD_ACCOUNT, account));
                categories.forEach(category => commit(types.ADD_CATEGORY, category));
                resolve()
            },
            () => reject()
        );
    })

};