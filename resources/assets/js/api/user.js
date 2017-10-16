export default {
    get (onSuccess, onError) {
        axios
            .get('/api/user')
            .then(response => {
                onSuccess(response.data)
            })
            .catch(onError || function () {
            });
    }
}