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
            url: '/api/categories'
        }, onSuccess, onError);
    },

    create(category, onSuccess, onError) {
        _sendRequest({
            method: 'post',
            url: '/api/categories',
            data: category
        }, onSuccess, onError);
    },

    update(category, onSuccess, onError) {
        _sendRequest({
            method: 'put',
            url: '/api/categories/' + category.id,
            data: category
        }, onSuccess, onError);
    },

    delete({id}, onSuccess, onError) {
        _sendRequest({
            method: 'delete',
            url: '/api/categories/' + id,
        }, onSuccess, onError);
    }
}