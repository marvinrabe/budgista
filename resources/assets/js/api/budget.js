export default {
    get (budget_id, onSuccess, onError) {
        axios
            .get('/api/budget')
            .then(response => {
                onSuccess(response.data)
            })
            .catch(onError || function () {
            });
    }
}