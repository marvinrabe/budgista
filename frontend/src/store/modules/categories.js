import _ from 'lodash'
import axios from 'axios'

// categories: [{ id, name, sort }]
const state = {
    categories: []
}

const getters = {
    sortedCategories(state) {
        return state.categories.slice().sort(function (a, b) {
            return a.sort - b.sort
        })
    },
    sortedCategoriesByGroup: (state) => (groupId) => {
        return state.categories.slice()
            .filter(x => x.group_id === groupId)
            .sort(function (a, b) {
                return a.sort - b.sort
            })
    },
    hasUngroupedCategories(state) {
        return state.categories.slice()
            .filter(x => x.group_id === null)
            .length > 0;
    },
    findCategoryById: (state) => (id) => {
        return state.categories.find(x => x.id === id)
    }
}

const actions = {

    loadCategories({commit}) {
        return axios
            .get('/categories/')
            .then(({data}) => {
                let categories = data.data
                categories.forEach(category => commit('ADD_CATEGORY', category))
            })
    },

    createCategory({commit}, category) {
        return axios
            .post('/categories/', category)
            .then(({data}) => {
                commit('ADD_CATEGORY', data.data)
            })
    },

    updateCategory({commit}, category) {
        return axios
            .put('/categories/' + category.id, {
                'name': category.name
            })
            .then(({data}) => {
                commit('ADD_CATEGORY', data.data)
            })
    },

    deleteCategory({commit}, {oldCategory, newCategory}) {
        return axios
            .delete('/categories/' + oldCategory.id, {
                data: {
                    category_id: _.get(newCategory, 'id', null)
                }
            })
            .then(() => {
                commit('REMOVE_CATEGORY', oldCategory)
                commit('TRANSFER_CATEGORY', {
                    from: oldCategory,
                    to: newCategory
                })
            })
    },

    sortCategories({commit}, {group_id, categories}) {
        commit('SORT_CATEGORIES', {group_id, categories})

        return axios.put('/categories/sort', {
            group_id: group_id,
            categories: categories.map(e => e.id)
        })
    }

}

const mutations = {
    RESET(state) {
        state.categories = []
    },
    ADD_CATEGORY(state, category) {
        state.categories = state.categories.filter(x => x.id !== category.id)
        state.categories.push(category)
    },
    SORT_CATEGORIES(state, {group_id, categories}) {
        state.categories.forEach(category => {
            let index = _.findIndex(categories, x => x.id === category.id)
            if (index !== -1) {
                category.group_id = group_id
                category.sort = index
            }
        })
    },
    REMOVE_CATEGORY(state, {id}) {
        state.categories = state.categories.filter(x => x.id !== id)
    },
    REMOVE_GROUP(state, {id}) {
        state.categories.forEach(category => {
            if (category.group_id === id) {
                category.group_id = null
            }
        })
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
