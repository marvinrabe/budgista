import * as types from './mutation-types'
import budget from '../api/budget'

export const initialize = ({ dispatch, commit }, budget_id) => {
    dispatch('loadBudget', budget_id);
};

export const loadBudget = ({ commit }, budget_id) => {
    return new Promise((resolve, reject) => {
        budget.get(
            budget_id,
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