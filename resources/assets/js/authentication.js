import axios from 'axios'
import store from './store';

export function initialize() {
    try {
        let jsonToken = window.localStorage.getItem('jwt')
        let token = JSON.parse(jsonToken)
        setToken(token)
    } catch (e) {
        removeToken()
    }
    return true;
}

export function removeToken() {
    store.commit('SET_TOKEN', null)
    window.localStorage.removeItem('jwt')
    axios.defaults.headers.common['Authorization'] = null
}

export function setToken(token) {
    if (token) {
        store.commit('SET_TOKEN', token)
        window.localStorage.setItem('jwt', JSON.stringify(token))
        axios.defaults.headers.common['Authorization'] = [
            token.token_type, token.access_token,
        ].join(' ')
    } else {
        removeToken()
    }
}
