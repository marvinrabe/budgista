
export default [
    {
        path: '/',
        name: 'budget',
        component: require('./components/budget/Index.vue')
    },
    {
        path: '/settings',
        name: 'settings',
        component: require('./components/settings/Index.vue'),
        children: [
            {
                path: '',
                name: 'settings.account',
                component: require('./components/settings/Account.vue')
            },
            {
                path: 'security',
                name: 'settings.security',
                component: require('./components/settings/Security.vue')
            }
        ]
    },
    {
        path: '/account/:account_id',
        name: 'account',
        component: require('./components/accounts/Index.vue'),
        props: true
    },
    {
        path: '/account/:account_id/newTransaction',
        name: 'transaction.new',
        component: require('./components/transactions/New.vue'),
        props: true
    },
    {
        path: '/transaction/:transaction_id',
        name: 'transaction.edit',
        component: require('./components/transactions/Edit.vue'),
        props: true
    }
];