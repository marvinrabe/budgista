
export const state = {
    user: {
        name: '',
        email: ''
    },
    language: 'en',
    locale: 'en',
    currency: 'EUR',
    loading: true
};

export const mutations = {
    LOAD_USER(state, user) {
        state.user.name = user.name;
        state.user.email = user.email;

        state.language = user.localization.language;
        state.locale = user.localization.locale;
        state.currency = user.localization.currency;

        state.loading = false;
    }
};
