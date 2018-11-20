<template>
    <div class="main">
        <app-toolbar :title="$t('action.create.transaction')"/>

        <div class="card">
            <div class="card-body">
                <transaction-form
                        :transaction="transaction"
                        @cancel="finish"
                        @success="finish"></transaction-form>
            </div>
        </div>
    </div>
</template>

<script>
    import TransactionForm from './TransactionForm'

    export default {
        props: ['account_id'],
        components: {
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
