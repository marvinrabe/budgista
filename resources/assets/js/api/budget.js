export default {
    get (onSuccess, onError) {
        axios
            .get('/api/')
            .then(response => {
                onSuccess(response.data)
            })
            .catch(onError || function () {
            });
    }
}