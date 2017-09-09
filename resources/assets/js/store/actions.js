import * as types from './mutation-types'
import budget from '../api/budget'

export const initialize = ({ dispatch, commit }, budget_id) => {
    dispatch('loadBudget', budget_id).then(() => {
        dispatch('loadAccounts');
    });
    
};

export const loadBudget = ({ commit }, budget_id) => {
    return new Promise((resolve, reject) => {
        budget.get(
            budget_id,
            ({data}) => {
                commit(types.LOAD_BUDGET, data);
                resolve()
            },
            () => reject()
        );
    })

};