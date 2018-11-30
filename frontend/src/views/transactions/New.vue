<template>
    <div class="main">
        <AppToolbar :title="$t('action.create.transaction')"/>

        <div class="card">
            <div class="card-body">
                <TransactionForm
                        :transaction="transaction"
                        @cancel="finish"
                        @success="finish"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import AppToolbar from '@/components/AppToolbar'
    import TransactionForm from '@/components/transactions/TransactionForm'

    export default {
        props: {
            account_id: String
        },
        components: {
            AppToolbar,
            TransactionForm
        },
        computed: {
            transaction() {
                return {
                    account_id: this.account_id
                }
            }
        },
        methods: {
            finish() {
                this.$router.push({name: 'account', params: {account_id: this.account_id}})
            }
        }
    }
</script>
