<template>
    <div id="layout">
        <div class="menu">
            <div class="app-menu">

                <nav class="navbar navbar-expand navbar-light">
                    <a class="navbar-brand logo" href="/">
                        {{ $t('app.name') }}
                    </a>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item d-md-none">
                            <a href="#" class="menu-toggle nav-link">
                                <span class="fa fa-times"></span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <nav class="nav flex-column">
                    <router-link
                            :to="{ name: 'budget.month', params: { budget: budget_id }}"
                            active-class="active" :exact="true" class="nav-link-main">
                        <span class="fa fa-envelope-o fa-fw"></span> {{ $t('title.budget') }}
                    </router-link>
                    <h6 class="nav-header">{{ $t('title.accounts') }}</h6>
                    <router-link
                            v-for="account in sortedAccounts" :key="account.id"
                            :to="{ name: 'budget.account', params: { account_id: account.id }}"
                            active-class="active" class="nav-link-main">
                        <span
                                class="float-right mt-1 badge"
                                :class="[{ 'badge-danger': account.workingBalance < 0 }, { 'badge-success': account.workingBalance >= 0 }]">
                            {{ $formatNumber(account.workingBalance, {style: 'currency', currency: currency}) }}
                        </span>
                        {{ account.name }}
                    </router-link>
                    <a v-on:click="showNewAccountModal" class="nav-link link-action text-muted small text-right">
                        <span class="fa fa-plus"></span> {{ $t('action.new.account') }}
                    </a>
                </nav>

            </div>
        </div>

        <router-view></router-view>

        <b-modal ref="newAccountModal" :title="$t('action.new.account')">
            <form @submit.stop.prevent="createAccount">
                <b-form-input type="text" :placeholder="$t('form.name')" v-model="newAccount.name"></b-form-input>
            </form>

            <div slot="modal-footer">
                <button class="btn btn-light" v-on:click="hideNewAccountModal">
                    {{ $t('action.cancel') }}
                </button>
                <button class="btn btn-primary" v-on:click="createAccount">
                    {{ $t('action.save') }}
                </button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        props: ['budget_id'],
        data: () => ({
            newAccount: {
                'name': ''
            }
        }),
        computed: {
            currency: function () {
                return window.currency;
            },
            ...mapGetters([
                'sortedAccounts'
            ])
        },
        created: function () {
            this.$store.dispatch('initialize', this.budget_id);
        },
        methods: {

            showNewAccountModal() {
                this.newAccount.name = '';
                this.$refs.newAccountModal.show();
            },
            hideNewAccountModal() {
                this.$refs.newAccountModal.hide();
            },
            createAccount() {
                this.$store.dispatch('createAccount', this.newAccount);

                this.hideNewAccountModal();
            }
        }
    }
</script>