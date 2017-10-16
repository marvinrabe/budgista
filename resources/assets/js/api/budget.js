export default {
    get (onSuccess, onError) {
        axios
            .get('/api/budget')
            .then(response => {
                onSuccess(response.data)
            })
            .catch(onError || function () {
            });
    }
}