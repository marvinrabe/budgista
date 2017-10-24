import * as types from './mutation-types'

export const state = {
    user: {
        name: '',
        email: ''
    },
    locale: 'en',
    currency: 'EUR',
    loading: true
};

export const mutations = {
    [types.LOAD_USER](state, user) {
        state.user.name = user.name;
        state.user.email = user.email;

        state.locale = user.locale;
        state.currency = user.currency;

        state.loading = false;
    }
};