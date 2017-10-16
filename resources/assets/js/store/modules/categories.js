import categories from '../../api/categories'
import * as types from '../mutation-types'

// initial state
// accounts: [{ id, name, sort }]
const state = {
    categories: []
};

// getters
const getters = {
    sortedCategories(state) {
        return state.categories.slice().sort(function (a, b) {
            return a.name.localeCompare(b.name);
        })
    },
    findCategoryById: (state) => (id) => {
        return state.categories.find(x => x.id === id)
    }
};

// actions
const actions = {

    loadCategories({commit, rootState}) {
        categories.getAll(
            ({data}) => data.forEach(category => commit(types.ADD_CATEGORY, category))
        )
    },

    createCategory({commit, rootState}, category) {
        categories.create(
            category,
            ({data}) => commit(types.ADD_CATEGORY, data)
        )
    },

    updateCategory({commit}, account) {
        categories.update(
            account,
            ({data}) => commit(types.ADD_CATEGORY, data)
        )
    },

    deleteCategory({commit}, account) {
        categories.delete(
            account,
            () => commit(types.REMOVE_CATEGORY, category)
        )
    },

};

// mutations
const mutations = {
    [types.ADD_CATEGORY](state, category) {
        state.categories = state.categories.filter(x => x.id !== category.id);
        state.categories.push(category);
    },
    [types.REMOVE_CATEGORY](state, {id}) {
        state.categories = state.categories.filter(x => x.id !== id);
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}