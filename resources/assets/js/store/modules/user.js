import {setLanguage} from '../../i18n'
import axios from 'axios'

const defaultState = {
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
            .get('/user')
            .then(({data}) => {
                setLanguage(data.data.language);
                commit('LOAD_USER', data.data);
            });
    },

    updateSettings({commit}, data) {
        return axios
            .put('/user', data)
            .then(({data}) => {
                setLanguage(data.data.language);
                commit('LOAD_USER', data.data);
            });
    },

    updateEmail({commit}, data) {
        return axios
            .post('/user/email', data)
            .then(({data}) => {
                commit('LOAD_USER', data.data);
            });
    },

    updatePassword({commit}, data) {
        return axios.post('/user/password', data);
    }

};

const mutations = {
    LOAD_USER(state, user) {
        state.email = user.email;
        state.language = user.language;
        state.locale = user.locale;
        state.currency = user.currency;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}