function _sendRequest(request, onSuccess, onError) {
    axios(request)
        .then(response => {
            onSuccess(response.data)
        })
        .catch(onError || function (e) {
            console.error(e);
        });
}

export default {
    getAll(budget_id, onSuccess, onError) {
        _sendRequest({
            method: 'get',
            url: '/api/budgets/' + budget_id + '/accounts'
        }, onSuccess, onError);
    },

    create(account, onSuccess, onError) {
        _sendRequest({
            method: 'post',
            url: '/api/accounts',
            data: account
        }, onSuccess, onError);
    },

    update(account, onSuccess, onError) {
        _sendRequest({
            method: 'post',
            url: '/api/accounts/' + account.id,
            data: account
        }, onSuccess, onError);
    },

    delete({id}, onSuccess, onError) {
        _sendRequest({
            method: 'post',
            url: '/api/accounts/' + id,
        }, onSuccess, onError);
    }
}