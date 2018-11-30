<template>
    <div>
        <div class="transactions-header">
            <div class="transaction-item">&nbsp;
                <div class="transaction-column">
                    <div class="transaction-date">{{ $t('form.date') }}</div>
                    <div class="transaction-payee">{{ $t('form.payee') }}</div>
                </div>
                <div class="transaction-column-2">
                    <div class="transaction-category">{{ $t('form.category') }}</div>
                    <div class="transaction-amount">{{ $t('form.amount') }}</div>
                </div>
            </div>
            <div class="transaction-clear">&nbsp;</div>
        </div>

        <div class="card">
            <TransactionListSkeleton v-if="isLoading"/>
            <TransactionListEmpty v-else-if="isEmpty"/>
            <template v-else>
                <div class="text-center p-1 transactions-row-dummy"
                     v-if="countFutureTransactions > 0 && !showFutureTransactions">
                    <a href="#" class="small" @click.prevent="showFutureTransactions = true">
                        {{ $tc('action.futureTransactions', countFutureTransactions, { count: countFutureTransactions
                        })}}
                    </a>
                </div>
                <TransactionListItem
                        v-for="transaction of filteredTransactions"
                        :key="transaction.id"
                        :transaction="transaction"
                />
            </template>
        </div>

        <InfiniteLoading
                ref="infiniteLoading"
                :key="account_id"
                @infinite="load"
        >
            <span slot="no-more"></span>
            <span slot="spinner">
                    <app-spinner></app-spinner>
            </span>
        </InfiniteLoading>
    </div>
</template>

<script>
    import AppSpinner from '../AppSpinner'
    import InfiniteLoading from 'vue-infinite-loading'
    import TransactionListEmpty from './TransactionListEmpty'
    import TransactionListItem from './TransactionListItem'
    import TransactionListSkeleton from './TransactionListSkeleton'

    export default {
        props: ['account_id'],
        components: {
            AppSpinner,
            InfiniteLoading,
            TransactionListEmpty,
            TransactionListItem,
            TransactionListSkeleton
        },
        data() {
            return {
                showFutureTransactions: false,
                loading: true
            }
        },
        computed: {
            isEmpty() {
                return this.$store.getters.areAccountTransactionsLoaded(this.account_id) && this.transactions.length === 0 && !this.loading
            },
            isLoading() {
                return !this.$store.getters.areAccountTransactionsLoaded(this.account_id)
            },
            filteredTransactions() {
                if (this.showFutureTransactions) {
                    return this.transactions
                }
                return this.transactions.filter(x => !x.isFuture())
            },
            transactions() {
                return this.$store.getters.findTransactionsByAccountId(this.account_id)
            },
            countFutureTransactions() {
                return this.$store.getters.countFutureTransactions(this.account_id)
            }
        },
        watch: {
            account_id() {
                this.showFutureTransactions = false
                this.load(this.$refs.infiniteLoading.stateChanger)
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            load: function (loader) {
                this.loading = true
                this.$store.dispatch('loadTransactions', this.account_id)
                    .then(() => {
                        if (loader) {
                            loader.loaded()
                        }
                    })
                    .catch(() => {
                        if (loader) {
                            loader.loaded()
                            loader.complete()
                        }
                    })
                    .finally(() => {
                        this.loading = false
                    })
            }
        }
    }
</script>
