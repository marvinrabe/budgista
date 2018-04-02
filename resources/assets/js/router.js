import Vue from 'vue'
import VueRouter from 'vue-router';
import Month from './models/Month'

Vue.use(VueRouter);

export const routes = [
    {
        path: '/login',
        name: 'login',
        component: require('./views/auth/Login.vue'),
    },
    {
        path: '/app',
        component: require('./components/AppLayout.vue'),
        children: [
            {
                path: '/budget',
                name: 'budget_default',
                redirect: to => {
                    return {name: 'budget', params: {month: Month.current().toString()}};
                }
            },
            {
                path: '/budget/:month',
                name: 'budget',
                component: require('./views/budget/Index.vue'),
                props: true
            },
            {
                path: '/categories',
                name: 'categories',
                component: require('./views/categories/Index.vue')
            },
            {
                path: '/settings',
                component: require('./views/settings/Index.vue'),
                children: [
                    {
                        path: '',
                        name: 'settings.account',
                        component: require('./views/settings/Account.vue')
                    },
                    {
                        path: 'security',
                        name: 'settings.security',
                        component: require('./views/settings/Security.vue')
                    }
                ]
            },
            {
                path: '/account/:account_id',
                name: 'account',
                component: require('./views/accounts/Index.vue'),
                props: true
            },
            {
                path: '/account/:account_id/newTransaction',
                name: 'transaction.new',
                component: require('./views/transactions/New.vue'),
                props: true
            },
            {
                path: '/transaction/:transaction_id',
                name: 'transaction.edit',
                component: require('./views/transactions/Edit.vue'),
                props: true
            }
        ]
    },
];

export const router = new VueRouter({
    mode: 'history',
    routes: routes
});