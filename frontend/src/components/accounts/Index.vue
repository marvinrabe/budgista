<template>
    <div v-if="account" class="main">
        <app-toolbar :title="account.name">
            <balance :account="account"></balance>

            <template slot="submenu">
                <account-settings :account="account"></account-settings>

                <router-link
                        :to="{ name: 'transaction.new'}"
                        class="btn btn-primary btn-sm"
                        :title="$t('action.create.transaction')">
                    <font-awesome-icon icon="plus"/>
                    {{ $t('word.transaction') }}
                </router-link>
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

        <div class="card">
            <template v-if="isLoading">
                <transaction-skeleton v-for="n in 25" :key="n"></transaction-skeleton>
            </template>
            <reconcile-form v-else-if="isEmpty" :account="account"></reconcile-form>
            <template v-else>
                <div class="text-center p-1 transactions-row-dummy"
                     v-if="countFutureTransactions > 0 && !showFutureTransactions">
                    <a href="#" class="small" @click.prevent="showFutureTransactions = true">
                        {{ $tc('action.futureTransactions', countFutureTransactions, { count: countFutureTransactions })}}
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

        <infinite-loading :key="account_id"
                          @infinite="load"
                          spinner="waveDots"
                          ref="infiniteLoading">
            <span slot="no-more"></span>
            <span slot="spinner">
                    <app-spinner></app-spinner>
                </span>
        </infinite-loading>
    </div>
</template>

<style>
    @media (max-width: 575.98px) {
        .toolbar .balance .numeric:first-child {
            align-items: flex-start !important;
        }
    }
</style>

<style scoped>
    @media (max-width: 575.98px) {
        .toolbar .title {
            order: 1;
        }

        .toolbar .button-right {
            order: 2;
        }

        .toolbar .balance {
            order: 3;
            flex: 100%;
            padding: 0;
            margin-top: .5em;
        }

        .toolbar .balance .numeric {
            text-align: center !important;
        }
    }
</style>

<script>
    import AppSpinner from '../AppSpinner'
    import Balance from './Balance.vue'
    import InfiniteLoading from 'vue-infinite-loading'
    import AccountSettings from './AccountSettings'
    import TransactionRow from './TransactionRow'
    import TransactionSkeleton from './TransactionSkeleton'
    import ReconcileForm from './ReconcileForm'

    export default {
        props: ['account_id'],
        components: {
            AppSpinner,
            AccountSettings,
            Balance,
            InfiniteLoading,
            ReconcileForm,
            TransactionRow,
            TransactionSkeleton
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
                this.load(this.$refs.infiniteLoading.stateChanger)
            }
        },
        mounted() {
            this.load()
        },
        beforeRouteUpdate(to, from, next) {
            this.showFutureTransactions = false
            next()
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
