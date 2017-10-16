import * as types from './mutation-types'

export const state = {
    user: null,
    loading: true
};

export const mutations = {
    [types.LOAD_USER](state, user) {
        state.user = user;
        state.loading = false;
    }
};