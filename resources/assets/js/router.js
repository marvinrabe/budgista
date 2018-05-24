import Vue from 'vue'
import VueRouter from 'vue-router'
import Month from './models/Month'

export const routes = [
    {
        path: '/auth',
        component: require('./components/layout/Auth.vue'),
        meta: {
            auth: false
        },
        children: [
            {
                path: 'login',
                name: 'login',
                component: require('./views/auth/Login.vue'),
            },
            {
                path: 'register',
                name: 'register',
                component: require('./views/auth/Register.vue'),
            },
        ]
    },
    {
        path: '/app',
        component: require('./components/layout/Default.vue'),
        meta: {
            auth: true
        },
        children: [
            {
                path: '',
                redirect: to => {
                    return {name: 'budget_default'}
                }
            },
            {
                path: 'budget',
                name: 'budget_default',
                redirect: to => {
                    return {name: 'budget', params: {month: Month.current().toString()}}
                }
            },
            {
                path: 'budget/:month',
                name: 'budget',
                component: require('./views/budget/Index.vue'),
                props: true
            },
            {
                path: 'categories',
                name: 'categories',
                component: require('./views/categories/Index.vue')
            },
            {
                path: 'settings',
                component: require('./views/settings/Index.vue'),
                children: [
                    {
                        path: '',
                        name: 'settings.general',
                        component: require('./views/settings/General.vue')
                    },
                    {
                        path: 'account',
                        name: 'settings.account',
                        component: require('./views/settings/Account.vue')
                    }
                ]
            },
            {
                path: 'account/:account_id',
                name: 'account',
                component: require('./views/accounts/Index.vue'),
                props: true
            },
            {
                path: 'account/:account_id/newTransaction',
                name: 'transaction.new',
                component: require('./views/transactions/New.vue'),
                props: true
            },
            {
                path: 'transaction/:transaction_id',
                name: 'transaction.edit',
                component: require('./views/transactions/Edit.vue'),
                props: true
            }
        ]
    },
]

export const router = new VueRouter({
    mode: 'history',
    routes: routes
})

Vue.use(VueRouter)
Vue.router = router