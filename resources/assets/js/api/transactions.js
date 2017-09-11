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
    getMoreTransactions(account_id, onSuccess, onError) {
        _sendRequest({
            method: 'get',
            url: '/api/accounts/' + account_id + '/transactions'
        }, onSuccess, onError);
    },

    create(transaction, onSuccess, onError) {
        _sendRequest({
            method: 'post',
            url: '/api/transactions',
            data: transaction
        }, onSuccess, onError);
    },

    update(transaction, onSuccess, onError) {
        _sendRequest({
            method: 'put',
            url: '/api/transactions/' + transaction.id,
            data: transaction
        }, onSuccess, onError);
    },

    clear(transaction, onSuccess, onError) {
        _sendRequest({
            method: 'put',
            url: '/api/transactions/' + transaction.id + '/clear'
        }, onSuccess, onError);
    },

    delete({id}, onSuccess, onError) {
        _sendRequest({
            method: 'delete',
            url: '/api/transactions/' + id,
        }, onSuccess, onError);
    }
}