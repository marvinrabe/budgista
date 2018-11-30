import axios from 'axios'
import collect from 'collect.js'
import Month from '@/models/Month'

// initial state
const state = {
    initialized: false,
    statistics: []
}

// getters
const getters = {
    labels: (state) => {
        return collect(state.statistics).map((x) => Month.fromString(x.month).format()).toArray()
    }
}

// actions
const actions = {

    fetch({commit, state}) {
        let apiRequest = axios.get('/statistics/monthly')
            .then(({data}) => {
                commit('onFetchSuccess', data.data)
                return data.data
            })

        if (state.initialized) {
            return Promise.resolve(state.statistics)
        }

        return apiRequest
    }

}

// mutations
const mutations = {
    RESET(state) {
        state.initialized = false
        state.statistics = []
    },
    onFetchSuccess(state, statistics) {
        state.initialized = true
        state.statistics = statistics
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
