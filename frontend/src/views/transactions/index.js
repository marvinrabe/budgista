import EditTransactions from '@/views/transactions/Edit'
import NewTransactions from '@/views/transactions/New'

export default [
    {
        path: 'transaction/create',
        name: 'transaction.new',
        component: NewTransactions,
        props: (route) => ({account_id: route.query.account})
    },
    {
        path: 'transaction/:transaction_id',
        name: 'transaction.edit',
        component: EditTransactions,
        props: true
    }
]
