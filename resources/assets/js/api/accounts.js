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
    getAll(onSuccess, onError) {
        _sendRequest({
            method: 'get',
            url: '/api/accounts'
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
            method: 'put',
            url: '/api/accounts/' + account.id,
            data: account
        }, onSuccess, onError);
    },

    delete({id}, onSuccess, onError) {
        _sendRequest({
            method: 'delete',
            url: '/api/accounts/' + id,
        }, onSuccess, onError);
    }
}