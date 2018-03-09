<template>
    <div v-if="account" class="main">
        <app-toolbar :title="account.name">
            <balance :account="account"></balance>

            <div slot="submenu">
                <a class="btn btn-secondary" href="#"
                   @click.stop="$refs.updateAccount.showModal(account)"
                   :title="$t('action.edit.account')">
                    <font-awesome-icon icon="cog"/>
                </a>
            </div>
        </app-toolbar>

        <router-link
                :to="{ name: 'transaction.new'}"
                class="floating-action btn btn-primary btn-lg rounded-circle"
                :title="$t('action.create.transaction')">
            <font-awesome-icon icon="plus"/>
        </router-link>

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
            <div class="text-center p-2 transactions-row-dummy"
                 v-if="countFutureTransactions > 0 && !showFutureTransactions">
                <a href="#" class="text-muted" @click.prevent="showFutureTransactions = true">
                    {{ $tc('action.futureTransactions', countFutureTransactions, { count: countFutureTransactions }) }}
                </a>
            </div>
            <div class="transactions-row"
                 :class="[{ 'transactions-row-future': moment(item.date).isAfter() }]"
                 v-if="!moment(item.date).isAfter() || showFutureTransactions"
                 v-for="(item, index) of transactions" :key="index">
                <router-link
                        class="transaction-item"
                        :to="{ name: 'transaction.edit', params: { transaction_id: item.id }}">
                    <span class="transaction-column">
                        <span class="transaction-date">
                            <date-format
                                    :value="item.date"
                                    :options="{year: 'numeric', month: '2-digit', day: '2-digit'}">
                            </date-format>
                            <span v-if="item.recurring"
                                  :title="humanRRule(item.rrule)">
                                <font-awesome-icon icon="sync" symbol/>
                            </span>
                        </span>
                        <span class="transaction-payee">
                            <ellipsis>{{ item.payee }}</ellipsis>
                        </span>
                    </span>
                    <span class="transaction-column-2">
                        <span class="transaction-category">
                            <ellipsis v-if="item.category">{{ item.category.name }}</ellipsis>
                        </span>
                        <span class="transaction-amount">
                            <money-format
                                    :class="[{ 'text-danger': item.amount < 0 }]"
                                    :value="item.amount">
                            </money-format>
                        </span>
                    </span>
                </router-link>
                <div class="transaction-clear">
                    <a href="#"
                       v-if="new Date(item.date) <= new Date()"
                       v-bind:class="[{ 'text-success': item.cleared }, {'text-darker-light': !item.cleared}]"
                       v-on:click="toggleCleared(item)">
                        <font-awesome-icon icon="check-circle" symbol/>
                    </a>
                </div>
            </div>
            <infinite-loading :key="account_id" @infinite="loadMore" spinner="waveDots" ref="infiniteLoading">
                <span slot="no-more"></span>
                <span slot="spinner">
                    <app-spinner></app-spinner>
                </span>
            </infinite-loading>
        </div>

        <update-account ref="updateAccount"></update-account>
    </div>
</template>

<style>
    .floating-action {
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 100;
    }
</style>

<script>
    import Balance from './Balance.vue';
    import InfiniteLoading from 'vue-infinite-loading';
    import UpdateAccount from './UpdateAccount';

    let rrulestr = require('rrule').rrulestr;

    export default {
        props: ['account_id'],
        components: {Balance, InfiniteLoading, UpdateAccount},
        data() {
            return {
                showFutureTransactions: false
            };
        },
        computed: {
            account() {
                return this.$store.getters.findAccountById(this.account_id);
            },
            transactions() {
                return this.$store.getters.findTransactionsByAccountId(this.account_id);
            },
            countFutureTransactions() {
                return this.$store.getters.countFutureTransactions(this.account);
            }
        },
        watch: {
            account_id() {
                this.$store.dispatch('loadTransactions', this.account_id);
            }
        },
        created() {
            this.$store.dispatch('loadTransactions', this.account_id);
        },
        beforeRouteUpdate (to, from, next) {
            this.showFutureTransactions = false;
            next();
        },
        methods: {
            humanRRule: function (rrule) {
                let rule = rrulestr(rrule);
                return rule.toText();
            },
            loadMore: function ($state) {
                this.$store.dispatch('loadMoreTransactions', this.account.id)
                    .then(() => {
                        $state.loaded();
                    })
                    .catch(() => {
                        $state.loaded();
                        $state.complete();
                    });
            },
            toggleCleared(transaction) {
                this.$store.dispatch('clearTransaction', transaction);
            }
        }

    }
</script>