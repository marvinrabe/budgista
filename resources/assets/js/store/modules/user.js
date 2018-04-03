import {setLanguage} from '../../i18n'
import axios from 'axios'

const defaultState = {
    token: null,
    email: '',
    language: 'en',
    locale: 'en',
    currency: 'EUR'
};

const state = defaultState;

const getters = {};

const actions = {

    loadUser({commit}) {
        return axios
            .get('/api/user')
            .then(({data}) => {
                setLanguage(data.data.language);
                commit('LOAD_USER', data.data);
            });
    },

    updateSettings({commit}, data) {
        return axios
            .put('/api/user', data)
            .then(({data}) => {
                setLanguage(data.data.language);
                commit('LOAD_USER', data.data);
            });
    },

    updateEmail({commit}, data) {
        return axios
            .post('/api/user/email', data)
            .then(({data}) => {
                commit('LOAD_USER', data.data);
            });
    },

    updatePassword({commit}, data) {
        return axios.post('/api/user/password', data);
    },

    login({commit}, data) {
        return axios
            .post('/api/auth/login', data)
            .then(({data}) => {
                axios.defaults.headers.common['Authorization'] = [
                    data.token_type, data.access_token,
                ].join(' ');
                commit('SET_TOKEN', data);
            });
    },

    logout({commit}) {
        axios.defaults.headers.common['Authorization'] = null;
        commit('RESET');

        return Promise.resolve();
    }

};

const mutations = {
    SET_TOKEN(state, token) {
        state.token = token;
    },
    LOAD_USER(state, user) {
        state.email = user.email;
        state.language = user.language;
        state.locale = user.locale;
        state.currency = user.currency;
    },
    RESET(state) {
        console.debug('reset?');
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}