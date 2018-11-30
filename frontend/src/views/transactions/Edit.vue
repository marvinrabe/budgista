<template>
    <div v-if="transaction" class="main">

        <app-toolbar :title="$t('action.edit.transaction')">
            <template slot="submenu">
                <button class="btn btn-light btn-sm"
                        type="button"
                        :title="$t('action.delete.transaction')"
                        @click="deleteTransaction">
                    <font-awesome-icon :icon="['far', 'trash-alt']"/>
                </button>
            </template>
        </app-toolbar>

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
    import TransactionForm from '@/components/transactions/TransactionForm'
    import store from '@/store/index'

    export default {
        props: ['transaction_id'],
        components: {
            TransactionForm
        },
        computed: {
            transaction() {
                return this.$store.getters.findTransactionById(this.transaction_id)
            }
        },
        beforeRouteEnter(to, from, next) {
            store.dispatch('loadTransaction', to.params.transaction_id)
                .then(() => {
                    next()
                })
                .catch((error) => {
                    next(error)
                })
        },
        methods: {
            finish() {
                this.$router.push({name: 'account', params: {account_id: this.transaction.account_id}})
            },

            deleteTransaction() {
                let transaction = {
                    'id': this.transaction_id
                }

                this.$store.dispatch('deleteTransaction', transaction)

                this.finish()
            }
        }
    }
</script>
