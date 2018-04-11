// categories: [{ id, name, sort }]
const state = {
    categories: []
};

const getters = {
    sortedCategories(state) {
        return state.categories.slice().sort(function (a, b) {
            return a.sort - b.sort;
        })
    },
    findCategoryById: (state) => (id) => {
        return state.categories.find(x => x.id === id)
    }
};

const actions = {

    loadCategories({commit}) {
        return axios
            .get('/categories/')
            .then(({data}) => {
                let categories = data.data;
                categories.forEach(category => commit('ADD_CATEGORY', category))
            });
    },

    createCategory({commit}, category) {
        return axios
            .post('/categories/', category)
            .then(({data}) => {
                commit('ADD_CATEGORY', data.data);
            });
    },

    updateCategory({commit}, category) {
        return axios
            .put('/categories/' + category.id, {
                'name': category.name
            })
            .then(({data}) => {
                commit('ADD_CATEGORY', data.data);
            });
    },

    deleteCategory({commit}, {oldCategory, newCategory}) {
        return axios
            .delete('/categories/' + oldCategory.id, {
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
            });
    },

    sortCategories({commit}, categories) {
        commit('SORT_CATEGORIES', categories);

        return axios.put('/categories/sort', {
            categories: categories.map(e => e.id)
        });
    }

};

const mutations = {
    RESET(state) {
        state.categories = []
    },
    ADD_CATEGORY(state, category) {
        state.categories = state.categories.filter(x => x.id !== category.id);
        state.categories.push(category);
    },
    SORT_CATEGORIES(state, sortedCategories) {
        state.categories.forEach(category => {
            category.sort = _.findIndex(sortedCategories, x => x.id === category.id);
        });
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