import * as types from './mutation-types'
import user from '../api/user'

export const initialize = ({ dispatch, commit }) => {
    dispatch('loadUser');
};

export const loadUser = ({ commit }) => {
    return new Promise((resolve, reject) => {
        user.get(
            ({data, accounts, categories}) => {
                commit(types.LOAD_USER, data);
                accounts.forEach(account => commit(types.ADD_ACCOUNT, account));
                categories.forEach(category => commit(types.ADD_CATEGORY, category));
                resolve()
            },
            () => reject()
        );
    })

};