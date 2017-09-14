function _sendRequest(request, onSuccess, onError) {
    axios(request)
        .then(response => {
            onSuccess(response.data)
        })
        .catch(onError || function (e) {
            console.error(e);
        });
}

let nextUrls = [];

export default {
    getMoreTransactions(account_id, onSuccess, onError) {
        let url = '/api/accounts/' + account_id + '/transactions';
        if(account_id in nextUrls) {
            if(nextUrls[account_id]) {
                url = nextUrls[account_id];
            } else {
                onSuccess({data:null});
                return;
            }
        }

        _sendRequest({
            method: 'get',
            url: url
        }, response => {
            nextUrls[account_id] = response.links.next;
            onSuccess(response);
        }, onError);
    },

    create(transaction, onSuccess, onError) {
        _sendRequest({
            method: 'post',
            url: '/api/transactions',
            data: transaction
        }, onSuccess, onError);
    },

    get(transaction_id, onSuccess, onError) {
        _sendRequest({
            method: 'get',
            url: '/api/transactions/' + transaction_id
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