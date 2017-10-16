<template>
    <div class="menu">
        <div class="app-menu">

            <nav class="navbar navbar-expand navbar-light">
                <a class="navbar-brand logo" href="/">
                    {{ $t('app.name') }}
                </a>

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" id="user-menu" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false" title="Settings">
                            <span class="fa fa-ellipsis-v"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="user-menu">
                            <div class="dropdown-static">
                                <strong>{{ user.name }}</strong><br>
                                <span class="text-muted">{{ user.email }}</span>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/settings">
                                {{ $t('title.settings') }}
                            </a>
                            <app-logout></app-logout>
                        </div>
                    </li>

                    <li class="nav-item d-md-none">
                        <a href="#" class="menu-toggle nav-link">
                            <span class="fa fa-times"></span>
                        </a>
                    </li>
                </ul>
            </nav>

            <nav class="nav flex-column">
                <router-link
                        :to="{ name: 'budget.month' }"
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
                <a v-on:click="showNewAccountModal" class="nav-link link-action text-muted small">
                    <span class="fa fa-plus"></span> {{ $t('action.new.account') }}
                </a>
            </nav>

        </div>

        <b-modal ref="newAccountModal" :title="$t('action.new.account')">
            <form @submit.stop.prevent="createAccount"
                  :class="[{'was-validated': newAccount.validated}]"
                  data-vv-scope="newAccount"
                  novalidate>
                <div class="form-group">
                    <label for="name" class="sr-only">{{$t('form.name')}}</label>
                    <input id="name" type="text" class="form-control"
                           :placeholder="$t('form.name')"
                           v-model="newAccount.name"
                           v-validate="'required'"
                           data-vv-name="name"
                           :data-vv-as="$t('form.name')">
                    <span class="invalid-feedback">{{ errors.first('newAccount.name') }}</span>
                </div>
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
    import {mapGetters} from 'vuex'
    import AppLogout from './AppLogout.vue'

    export default {
        components: {
            AppLogout
        },
        data: () => ({
            newAccount: {
                name: '',
                validated: false
            }
        }),
        computed: {
            currency: function () {
                return window.currency;
            },
            user () {
                return this.$store.state.user;
            },
            ...mapGetters([
                'sortedAccounts',
                'sortedAccounts'
            ])
        },
        methods: {

            showNewAccountModal() {
                // Reset Validation
                this.newAccount.validated = false;
                this.errors.clear('newAccount');

                // Reset Data
                this.newAccount.name = '';

                // Show Modal
                this.$refs.newAccountModal.show();
            },
            hideNewAccountModal() {
                // Hide Modal
                this.$refs.newAccountModal.hide();
            },
            createAccount() {
                this.$validator.validateAll('newAccount').then(isValid => {
                    this.newAccount.validated = true;

                    if (isValid) {
                        this.$store.dispatch('createAccount', this.newAccount);
                        this.hideNewAccountModal();
                    }
                });
            }
        }
    }
</script>