import Vue from 'vue';

Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
    authRedirect: {name: 'login'},
    forbiddenRedirect: {name: 'budget_default'},
    notFoundRedirect: {name: 'budget_default'}
});
