import Vue from 'vue'
import Month from './models/Month'
import Router from 'vue-router'

Vue.use(Router)

export const guestRoutes = {
    path: '/',
    component: require('./components/layout/Auth.vue').default,
    meta: {
        auth: false
    },
    children: [
        {
            path: '',
            redirect: () => {
                return {name: 'login'}
            }
        },
        {
            path: 'login',
            name: 'login',
            component: require('./components/auth/Login.vue').default
        },
        {
            path: 'register',
            name: 'register',
            component: require('./components/auth/Register.vue').default
        },
        {
            path: 'reset-password',
            name: 'send_reset',
            component: require('./components/auth/Email.vue').default
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
}

import Statistics from '@/views/statistics'
import Transactions from '@/views/transactions'

export const userRoutes = {
    path: '/',
    component: require('./components/layout/Default.vue').default,
    meta: {
        auth: true
    },
    children: [
        {
            path: '',
            redirect: () => {
                return {name: 'budget_default'}
            }
        },
        {
            path: 'budget',
            name: 'budget_default',
            redirect: () => {
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
        ...Statistics,
        ...Transactions
    ]
}

export const routes = [
    guestRoutes,
    userRoutes,
    {path: '*', component: require('./components/layout/PageNotFound.vue').default}
]

export const router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: routes
})

Vue.router = router

export default router
