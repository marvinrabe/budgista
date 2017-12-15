<template>
    <div v-if="account" class="main">

        <app-window :title="account.name"></app-window>

        <div class="toolbar toolbar-primary">

            <app-sidebar-toggle></app-sidebar-toggle>

            <a class="col-flex h2 mb-0 hide-text-overflow" href="#"
               @click.stop="showEditAccountModal"
               :title="$t('action.edit.account')">
                {{ account.name }}
            </a>

            <balance :account="account"></balance>
        </div>

        <div class="toolbar toolbar-secondary">
            <div class="col-flex">
                <router-link
                        :to="{ name: 'budget.newTransaction'}"
                        class="btn btn-primary">
                    <span class="fa fa-plus"></span> {{ $t('action.new.transaction') }}
                </router-link>
            </div>
        </div>

        <div class="content transactions">
            <div class="transactions-header">
                <div class="transaction-clear">&nbsp;</div>
                <div class="transaction-column">
                    <div class="transaction-date">{{ $t('form.date') }}</div>
                    <div class="transaction-payee">{{ $t('form.payee') }}</div>
                </div>
                <div class="transaction-column-2">
                    <div class="transaction-category">{{ $t('form.category') }}</div>
                    <div class="transaction-amount">{{ $t('form.amount') }}</div>
                </div>
                <div class="transaction-outflow">{{ $t('form.outflow') }}</div>
                <div class="transaction-inflow">{{ $t('form.inflow') }}</div>
                <div class="transaction-actions">&nbsp;</div>
            </div>

            <div class="transactions-row" :class="[{ 'transactions-row-future': new Date(item.date) > new Date() }]"
                 v-for="(item, index) of transactions" :key="index">
                <div class="transaction-clear">
                    <button class="btn btn-xs"
                            v-if="new Date(item.date) <= new Date()"
                            v-bind:class="[{ 'btn-success': item.cleared }, {'btn-light': !item.cleared}]"
                            v-on:click="toggleCleared(item)">
                        <span class="fa fa-check"></span>
                    </button>
                </div>
                <div class="transaction-column">
                    <div class="transaction-date">
                        <date-format
                                :value="item.date"
                                :options="{year: 'numeric', month: '2-digit', day: '2-digit'}">
                        </date-format>
                        <span class="fa fa-refresh"
                              v-if="item.recurring"
                              v-b-tooltip.bottom
                              v-bind:title="humanRRule(item.rrule)">
                    </span>
                    </div>
                    <div class="transaction-payee">{{ item.payee }}</div>
                </div>
                <div class="transaction-column-2">
                    <div class="transaction-category">
                        <span v-if="item.category">
                            {{ item.category.name }}
                        </span>
                        <div v-else class="text-light text-center">
                            &mdash;
                        </div>
                    </div>
                    <div class="transaction-amount">
                        <money-format
                                :class="[{ 'text-danger': item.amount < 0 }, { 'text-success': item.amount >= 0 }]"
                                :value="item.amount">
                        </money-format>
                    </div>
                </div>
                <div class="transaction-outflow">
                    <money-format
                            v-if="item.amount < 0"
                            :value="-1*item.amount">
                    </money-format>
                </div>
                <div class="transaction-inflow">
                    <money-format
                            v-if="item.amount >= 0"
                            :value="item.amount">
                    </money-format>
                </div>
                <div class="transaction-actions">
                    <router-link
                            :to="{ name: 'budget.transaction', params: { transaction_id: item.id }}"
                            :title="$t('action.edit.transaction')" class="text-muted">
                        <span class="fa fa-pencil"></span>
                    </router-link>
                </div>
            </div>
            <infinite-loading :key="account_id" @infinite="loadMore" spinner="waveDots" ref="infiniteLoading">
                <span slot="no-more"></span>
                <span slot="spinner">
                    <app-spinner></app-spinner>
                </span>
            </infinite-loading>
        </div>

        <modal v-if="editAccount.modalVisible" @close="hideEditAccountModal" :title="$t('action.edit.account')">
            <form slot="body"
                  @submit.stop.prevent="updateAccount"
                  :class="[{'was-validated': editAccount.validated}]"
                  data-vv-scope="editAccount"
                  novalidate>
                <div class="form-group">
                    <label for="name" v-html="$t('form.name')"></label>
                    <input id="name" type="text" class="form-control"
                           v-model="editAccount.name"
                           v-focus
                           v-validate="'required'"
                           data-vv-name="name"
                           :data-vv-as="$t('form.name')">
                    <span class="invalid-feedback">{{ errors.first('editAccount.name') }}</span>
                </div>
            </form>
            <div slot="footer">
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
        </modal>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';
    import Balance from './Balance.vue';

    var rrulestr = require('rrule').rrulestr;

    export default {
        props: ['account_id'],
        components: {
            Balance,
            InfiniteLoading
        },
        computed: {
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
                name: '',
                validated: false,
                active: false,
                modalVisible: false
            }
        }),
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
            },

            showEditAccountModal() {
                // Reset Validation
                this.editAccount.validated = false;
                this.errors.clear('editAccount');

                // Reset Data
                this.editAccount.id = this.account.id;
                this.editAccount.name = this.account.name;

                this.editAccount.modalVisible = true;
            },
            hideEditAccountModal() {
                this.editAccount.modalVisible = false;
            },
            updateAccount() {
                this.$validator.validateAll('editAccount').then(isValid => {
                    this.editAccount.validated = true;

                    if (isValid) {
                        this.$store.dispatch('updateAccount', this.editAccount);
                        this.hideEditAccountModal();
                    }
                });
            },
            deleteAccount() {
                this.$store.dispatch('deleteAccount', this.editAccount);

                this.hideEditAccountModal();

                this.$router.push({name: 'budget.month'});
            },
        }

    }
</script>