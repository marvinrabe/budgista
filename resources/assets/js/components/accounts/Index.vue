<template>
    <div v-if="account" class="main">
        <header>
            <app-toolbar :title="account.name">
                <balance :account="account"></balance>
            </app-toolbar>

            <div class="toolbar toolbar-secondary">
                <router-link
                        :to="{ name: 'transaction.new'}"
                        class="btn btn-primary">
                    <font-awesome-icon icon="plus"/>
                    {{ $t('action.new.transaction') }}
                </router-link>

                <a class="btn btn-primary ml-auto" href="#"
                   @click.stop="showEditAccountModal"
                   :title="$t('action.edit.account')">
                    <font-awesome-icon icon="cog"/>
                </a>
            </div>

            <div class="container-fluid">
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
            </div>
        </header>

        <div class="content container-fluid">
            <div class="transactions-row" :class="[{ 'transactions-row-future': new Date(item.date) > new Date() }]"
                 v-for="(item, index) of transactions" :key="index">
                <router-link
                        :to="{ name: 'transaction.edit', params: { transaction_id: item.id }}"
                        :title="$t('action.edit.transaction')" class="transaction-item">
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
                        <font-awesome-icon :icon="['far', 'trash-alt']"/>
                    </button>
                </div>

                <button class="btn btn-text-light" v-on:click="hideEditAccountModal">
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

                this.$router.push({name: 'budget'});
            },
        }

    }
</script>