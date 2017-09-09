import * as types from './mutation-types'

export const state = {
    user: null,
    budget: null,
    loading: true
};

export const mutations = {
    [types.LOAD_BUDGET](state, budget) {
        state.budget = budget;
        state.loading = false;
    }
};