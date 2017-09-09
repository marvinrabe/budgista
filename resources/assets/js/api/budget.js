export default {
    get (budget_id, onSuccess, onError) {
        axios
            .get('/api/budgets/' + budget_id)
            .then(response => {
                onSuccess(response.data)
            })
            .catch(onError || function () {
            });
    }
}