<template>
    <div v-if="account" class="main">

        <window :title="account.name"></window>

        <div class="toolbar toolbar-primary">
            <div class="d-md-none">
                <button class="menu-toggle btn" type="button"
                        aria-controls="menu" :aria-label="$t('action.navigation')">
                    <span class="fa fa-navicon"></span>
                </button>
            </div>

            <div class="col-flex h2 mb-0 hide-text-overflow">
                {{ account.name }}
            </div>
            <div class="text-right d-none d-md-block">
                <strong :class="[{ 'text-success': account.clearedBalance >= 0}, { 'text-danger': account.clearedBalance < 0}]">
                    {{ $formatNumber(account.clearedBalance, {style: 'currency', currency: currency}) }}
                </strong>
                <p class="small">{{ $t('form.balance.cleared') }}</p>
            </div>
            <div class="text-right d-none d-md-block">
                <strong :class="[{ 'text-success': account.unclearedBalance >= 0}, { 'text-danger': account.unclearedBalance < 0}]">
                    {{ $formatNumber(account.unclearedBalance, {style: 'currency', currency: currency}) }}
                </strong>
                <p class="small">{{ $t('form.balance.uncleared') }}</p>
            </div>
            <div class="text-right">
                <strong :class="[{ 'text-success': account.workingBalance >= 0}, { 'text-danger': account.workingBalance < 0}]">
                    {{ $formatNumber(account.workingBalance, {style: 'currency', currency: currency}) }}
                </strong>
                <p class="small">{{ $t('form.balance.working') }}</p>
            </div>
        </div>

        <div class="toolbar toolbar-secondary">
            <div class="row">
                <div class="col">
                    <router-link
                            :to="{ name: 'budget.newTransaction'}"
                            class="btn btn-primary">
                        <span class="fa fa-plus"></span> {{ $t('action.new.transaction') }}
                    </router-link>
                </div>

                <div class="col text-right">
                    <button v-on:click="showEditAccountModal" class="btn btn-secondary"
                            :title="$t('action.edit.account')">
                        <span class="fa fa-cog"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="content transactions" style="overflow: auto;">
            <div class="transactions-header">
                <div class="transaction-clear">&nbsp;</div>
                <div class="transaction-date">{{ $t('form.date') }}</div>
                <div class="transaction-payee">{{ $t('form.payee') }}</div>
                <div class="transaction-category">{{ $t('form.category') }}</div>
                <div class="transaction-outflow">{{ $t('form.outflow') }}</div>
                <div class="transaction-inflow">{{ $t('form.inflow') }}</div>
                <div class="transaction-amount">{{ $t('form.amount') }}</div>
                <div class="transaction-actions">&nbsp;</div>
            </div>

            <div class="transactions-row" :class="[{ 'text-muted bg-light': new Date(item.date) > new Date() }]"
                 v-for="(item, index) of transactions" :key="index">
                <div class="transaction-clear">
                    <button class="btn btn-xs"
                            :class="[{ 'btn-success': item.cleared }, {'btn-light': !item.cleared}]"
                            v-if="new Date(item.date) <= new Date()"
                            v-on:click="toggleCleared(item)">
                        <span class="fa fa-check"></span>
                    </button>
                </div>
                <div class="transaction-date">
                    {{ $formatDate(new Date(item.date), {year: 'numeric', month: '2-digit', day: '2-digit'}) }}
                    <span v-if="item.recurring" class="fa fa-refresh" v-b-tooltip.bottom
                          :title="humanRRule(item.rrule)">
                        </span>
                </div>
                <div class="transaction-payee">{{ item.payee }}</div>
                <div class="transaction-category">
                        <span v-if="item.category">
                            {{ item.category.name }}
                        </span>
                </div>
                <div class="transaction-outflow">
                        <span v-if="item.amount < 0">
                            {{ $formatNumber(item.amount * -1, {style: 'currency', currency: currency}) }}
                        </span>
                </div>
                <div class="transaction-inflow">
                        <span v-if="item.amount >= 0">
                            {{ $formatNumber(item.amount, {style: 'currency', currency: currency}) }}
                        </span>
                </div>
                <div class="transaction-amount">
                        <span :class="[{ 'text-danger': item.amount < 0 }, { 'text-success': item.amount >= 0 }]"
                              v-html="$formatNumber(item.amount, {style: 'currency', currency: currency})"></span>
                </div>
                <div class="transaction-actions">
                    <router-link
                            :to="{ name: 'budget.transaction', params: { transaction_id: item.id }}"
                            :title="$t('action.edit.transaction')" class="text-muted">
                        <span class="fa fa-pencil"></span>
                    </router-link>
                </div>
            </div>
            <infinite-loading :key="account_id" :on-infinite="loadMore" spinner="waveDots" ref="infiniteLoading">
                <span slot="no-more">
                  {{ $t('message.noMoreData') }}
                </span>
            </infinite-loading>
        </div>

        <b-modal ref="editAccountModal" :title="$t('action.edit.account')">
            <form @submit.stop.prevent="editAccount">
                <b-form-input type="text" :placeholder="$t('form.name')" v-model="editAccount.name"></b-form-input>
            </form>
            <div slot="modal-footer" class="text-right" style="width: 100%;">
                <div class="float-left">
                    <button class="btn btn-outline-danger"
                            :title="$t('action.delete.account')"
                            v-on:click="deleteAccount">
                        <span class="fa fa-trash"></span>
                    </button>
                </div>

                <button class="btn btn-light" v-on:click="hideEditAccountModal">
                    {{ $t('action.cancel') }}
                </button>
                <button class="btn btn-primary" v-on:click="updateAccount">
                    {{ $t('action.save') }}
                </button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';

    var rrulestr = require('rrule').rrulestr;

    export default {
        props: ['account_id'],
        components: {
            InfiniteLoading,
        },
        computed: {
            currency: function () {
                return window.currency;
            },
            account() {
                return this.$store.getters.findAccountById(this.account_id);
            },
            transactions() {
                return this.$store.getters.findTransactionsByAccountId(this.account_id);
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
        data: () => ({
            editAccount: {
                id: '',
                name: ''
            }
        }),
        methods: {
            humanRRule: function (rrule) {
                let rule = rrulestr(rrule);
                return rule.toText();
            },

            loadMore: function () {
                this.$store.dispatch('loadMoreTransactions', this.account.id)
                    .then(() => {
                        this.$refs.infiniteLoading.$emit('$InfiniteLoading:loaded');
                    })
                    .catch(() => {
                        this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete');
                    });
            },
            toggleCleared(transaction) {
                this.$store.dispatch('clearTransaction', transaction);
            },

            showEditAccountModal() {
                this.editAccount.id = this.account.id;
                this.editAccount.name = this.account.name;

                this.$refs.editAccountModal.show();
            },
            hideEditAccountModal() {
                this.$refs.editAccountModal.hide();
            },
            updateAccount() {
                this.$store.dispatch('updateAccount', this.editAccount);

                this.hideEditAccountModal();
            },
            deleteAccount() {
                this.$store.dispatch('deleteAccount', this.editAccount);

                this.hideEditAccountModal();

                this.$router.push({name: 'budget.month'});
            },
        }

    }
</script>