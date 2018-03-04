import categories from '../../api/categories'

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
            ({data}) => data.forEach(category => commit('ADD_CATEGORY', category))
        )
    },

    createCategory({commit, rootState}, category) {
        categories.create(
            category,
            ({data}) => commit('ADD_CATEGORY', data)
        )
    },

    updateCategory({commit}, category) {
        categories.update(
            category,
            ({data}) => commit('ADD_CATEGORY', data)
        )
    },

    deleteCategory({commit}, {oldCategory, newCategory}) {
        return axios
            .delete('/api/categories/' + oldCategory.id, {
                data: {
                    category_id: _.get(newCategory, 'id', null)
                }
            })
            .then(response => {
                commit('REMOVE_CATEGORY', oldCategory);
                commit('TRANSFER_CATEGORY', {
                    from: oldCategory,
                    to: newCategory
                });
            })
            .catch(e => {
                console.error(e);
            });
    }

};

// mutations
const mutations = {
    ADD_CATEGORY(state, category) {
        state.categories = state.categories.filter(x => x.id !== category.id);
        state.categories.push(category);
    },
    REMOVE_CATEGORY(state, {id}) {
        state.categories = state.categories.filter(x => x.id !== id);
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}