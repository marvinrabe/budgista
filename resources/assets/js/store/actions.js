import user from '../api/user'

export const initialize = ({dispatch, commit}) => {
    dispatch('loadUser');
};

export const loadUser = ({commit}) => {
    return new Promise((resolve, reject) => {
        user.get(
            ({data, accounts, categories}) => {
                commit('LOAD_USER', data);
                accounts.forEach(account => commit('ADD_ACCOUNT', account));
                categories.forEach(category => commit('ADD_CATEGORY', category));
                resolve()
            },
            () => reject()
        );
    })
};

export const updateEmail = ({commit}, data) => {
    return axios
        .post('/api/user/email', data)
        .then(({data}) => {
            commit('LOAD_USER', data.data);
        });
};