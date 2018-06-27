import _ from 'lodash'

// groups: [{ id, name, sort }]
const state = {
    groups: []
};

const getters = {
    sortedGroups(state) {
        return state.groups.slice().sort(function (a, b) {
            return a.sort - b.sort;
        })
    },
    findGroupById: (state) => (id) => {
        return state.groups.find(x => x.id === id)
    }
};

const actions = {

    loadGroups({commit}) {
        return axios
            .get('/groups/')
            .then(({data}) => {
                let groups = data.data;
                groups.forEach(group => commit('ADD_GROUP', group))
            });
    },

    createGroup({commit}, group) {
        return axios
            .post('/groups/', group)
            .then(({data}) => {
                commit('ADD_GROUP', data.data);
            });
    },

    updateGroup({commit}, group) {
        return axios
            .put('/groups/' + group.id, {
                'name': group.name
            })
            .then(({data}) => {
                commit('ADD_GROUP', data.data);
            });
    },

    deleteGroup({commit}, group) {
        return axios
            .delete('/groups/' + group.id)
            .then(response => {
                commit('REMOVE_GROUP', group);
            });
    },

    sortGroups({commit}, groups) {
        commit('SORT_GROUPS', groups);

        return axios.put('/groups/sort', {
            groups: groups.map(e => e.id)
        });
    }

};

const mutations = {
    RESET(state) {
        state.groups = []
    },
    ADD_GROUP(state, group) {
        state.groups = state.groups.filter(x => x.id !== group.id);
        state.groups.push(group);
    },
    SORT_GROUPS(state, sortedGroups) {
        state.groups.forEach(group => {
            group.sort = _.findIndex(sortedGroups, x => x.id === group.id);
        });
    },
    REMOVE_GROUP(state, {id}) {
        state.groups = state.groups.filter(x => x.id !== id);
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}