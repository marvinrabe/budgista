import Vue from 'vue'
import Month from './models/Month'
import Router from 'vue-router'

Vue.use(Router)

export const routes = [
    {
        path: '/',
        component: require('./components/layout/Auth.vue').default,
        meta: {
            auth: false
        },
        children: [
            {
                path: '',
                redirect: to => {
                    return {name: 'login'}
                }
            },
            {
                path: 'login',
                name: 'login',
                component: require('./components/auth/Login.vue').default,
            },
            {
                path: 'register',
                name: 'register',
                component: require('./components/auth/Register.vue').default,
            },
            {
                path: 'reset-password',
                name: 'send_reset',
                component: require('./components/auth/Email.vue').default,
            },
            {
                path: 'reset-password/:token',
                name: 'reset',
                component: require('./components/auth/Reset.vue').default,
                props: true
            },
            {
                path: 'verify/:token',
                name: 'verify',
                component: require('./components/auth/Verify.vue').default,
                props: true,
                meta: {
                    auth: undefined
                }
            }
        ]
    },
    {
        path: '/',
        component: require('./components/layout/Default.vue').default,
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
                component: require('./components/budget/Index.vue').default,
                props: true
            },
            {
                path: 'statistics',
                name: 'statistics',
                component: require('./components/statistics/Index.vue').default
            },
            {
                path: 'settings',
                name: 'settings',
                component: require('./components/settings/Index.vue').default
            },
            {
                path: 'profile',
                name: 'profile',
                component: require('./components/profile/Index.vue').default
            },
            {
                path: 'leave',
                name: 'leave',
                component: require('./components/profile/Delete.vue').default
            },
            {
                path: 'account/:account_id',
                name: 'account',
                component: require('./components/accounts/Index.vue').default,
                props: true
            },
            {
                path: 'account/:account_id/newTransaction',
                name: 'transaction.new',
                component: require('./components/transactions/New.vue').default,
                props: true
            },
            {
                path: 'transaction/:transaction_id',
                name: 'transaction.edit',
                component: require('./components/transactions/Edit.vue').default,
                props: true
            }
        ]
    },
    { path: "*", component: require('./components/layout/PageNotFound.vue').default }
]

export const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: routes
})

Vue.router = router

export default router
