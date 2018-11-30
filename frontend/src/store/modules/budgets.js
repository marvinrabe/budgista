import axios from 'axios'
import Vue from 'vue'
import _ from 'lodash'

// initial state
const state = {
    entities: {}
}

// getters
const getters = {
    has: (state, getters) => (month) => {
        return getters.byMonth(month) !== undefined
    },
    byMonth: (state) => (month) => {
        return state.entities[month.toString()]
    },
    getRows: (state, getters) => (month) => {
        let budget = getters.byMonth(month)
        return budget ? getters.byMonth(month).rows : []
    },
    getRow: (state, getters) => (month, category_id) => {
        let row = getters.getRows(month).find(x => x.id === category_id)
        return row ? row : {
            month: month.toString(),
            budget: 0,
            previousMonth: 0,
            recommendedBudget: 0,
            activity: 0,
            available: 0
        }
    }
}

// actions
const actions = {

    fetchSingle({commit, getters}, month) {
        let apiRequest = axios
            .get('/month/' + month.toString())
            .then(({data}) => {
                commit('onFetchSingleSuccess', data.data)
                return data.data
            })

        if (getters.has(month)) {
            return Promise.resolve(getters.byMonth(month))
        }

        return apiRequest
    },

    update({commit, getters}, row) {
        let previous = getters.getRow(row.month, row.id)

        commit('onUpdate', row)
        axios
            .put('/categories/' + row.id + '/budget', {
                'month': row.month,
                'amount': row.budget
            })
            .then(({data}) => {
                commit('onUpdateSuccess', data)
                return data
            })
            .catch(() => {
                commit('onUpdateFailure', previous)
            })
    }

}

let updateRow = (state, row) => {
    let rows = _.get(state.entities[row.month], 'rows', null)
    if (rows) {
        var index = _.findIndex(rows, {id: row.id})

        if (index !== -1) {
            state.entities[row.month].rows.splice(index, 1)
        }
        state.entities[row.month].rows.push(row)
    }
}

// mutations
const mutations = {
    RESET(state) {
        state.entities = {}
    },
    onFetchSingleSuccess(state, budget) {
        Vue.set(state.entities, budget.month, budget)
    },
    onUpdate: updateRow,
    onUpdateFailure: updateRow,
    onUpdateSuccess: updateRow
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
