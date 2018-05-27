<template>
    <div v-if="account" class="main">
        <app-toolbar :title="account.name">
            <balance :account="account"></balance>

            <template slot="submenu">
                <router-link
                        :to="{ name: 'transaction.new'}"
                        class="btn btn-primary btn-sm"
                        :title="$t('action.create.transaction')">
                    <font-awesome-icon icon="plus"/>
                    {{ $t('word.transaction') }}
                </router-link>

                <account-settings :account="account"></account-settings>
            </template>
        </app-toolbar>

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

        <div class="content">
            <reconcile-form v-if="isEmpty" :account="account"></reconcile-form>
            <template v-else>
                <div class="text-center p-1 transactions-row-dummy"
                     v-if="countFutureTransactions > 0 && !showFutureTransactions">
                    <a href="#" class="small" @click.prevent="showFutureTransactions = true">
                        {{ $tc('action.futureTransactions', countFutureTransactions, { count: countFutureTransactions })
                        }}
                    </a>
                </div>
                <transaction-row
                        v-for="transaction of transactions"
                        v-if="!transaction.isFuture() || showFutureTransactions"
                        :key="transaction.id"
                        :transaction="transaction">
                </transaction-row>
            </template>
        </div>

        <infinite-loading v-if="!isEmpty" :key="account_id" @infinite="loadMore" spinner="waveDots"
                          ref="infiniteLoading">
            <span slot="no-more"></span>
            <span slot="spinner">
                    <app-spinner></app-spinner>
                </span>
        </infinite-loading>
    </div>
</template>

<script>
    import Balance from './Balance.vue'
    import InfiniteLoading from 'vue-infinite-loading'
    import AccountSettings from './AccountSettings'
    import TransactionRow from './TransactionRow'
    import ReconcileForm from './ReconcileForm'

    export default {
        props: ['account_id'],
        components: {
            AccountSettings,
            Balance,
            InfiniteLoading,
            ReconcileForm,
            TransactionRow
        },
        data() {
            return {
                showFutureTransactions: false,
                loading: true
            }
        },
        computed: {
            isEmpty() {
                return this.transactions.length === 0 && !this.loading
            },
            account() {
                return this.$store.getters.findAccountById(this.account_id)
            },
            transactions() {
                return this.$store.getters.findTransactionsByAccountId(this.account_id)
            },
            countFutureTransactions() {
                return this.$store.getters.countFutureTransactions(this.account)
            }
        },
        watch: {
            account_id() {
                this.$store.dispatch('loadTransactions', this.account_id)
            }
        },
        created() {
            this.$store.dispatch('loadTransactions', this.account_id)
        },
        beforeRouteUpdate(to, from, next) {
            this.showFutureTransactions = false
            this.loading = true
            next()
        },
        methods: {
            loadMore: function ($state) {
                this.loading = true
                this.$store.dispatch('loadMoreTransactions', this.account.id)
                    .then(() => {
                        $state.loaded()
                    })
                    .catch(() => {
                        $state.loaded()
                        $state.complete()
                    })
                    .finally(() => {
                        this.loading = false
                    })
            }
        }
    }
</script>