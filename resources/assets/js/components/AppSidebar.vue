<template>
    <div class="menu" @click="hideMenu">
        <div class="app-menu" @click.stop>

            <nav class="navbar navbar-expand navbar-light">
                <a class="navbar-brand logo" href="/">
                    {{ $t('app.name') }}
                </a>

                <ul class="navbar-nav ml-auto d-md-none">
                    <li class="nav-item">
                        <a href="#" class="nav-link" @click="hideMenu">
                            <font-awesome-icon icon="times"/>
                        </a>
                    </li>
                </ul>
            </nav>

            <nav class="nav flex-column">
                <router-link
                        :to="{ name: 'budget.month' }"
                        @click.native="hideMenu"
                        active-class="active" :exact="true" class="nav-link-main">
                    <font-awesome-icon :icon="['far', 'envelope']" fixed-width/>
                    {{ $t('title.budget') }}
                </router-link>
                <h6 class="nav-header">{{ $t('title.accounts') }}</h6>
                <router-link
                        v-for="account in sortedAccounts" :key="account.id"
                        :to="{ name: 'budget.account', params: { account_id: account.id }}"
                        @click.native="hideMenu"
                        active-class="active" class="nav-link-main">
                    <money-format
                            class="float-right mt-1 badge"
                            :class="[{ 'badge-danger': account.workingBalance < 0 }, { 'badge-success': account.workingBalance >= 0 }]"
                            :value="account.workingBalance">
                    </money-format>
                    {{ account.name }}
                </router-link>
                <a v-on:click="showNewAccountModal" class="nav-link link-action text-muted small">
                    <font-awesome-icon icon="plus"/>
                    {{ $t('action.new.account') }}
                </a>
            </nav>

            <ul class="nav-small">
                <li>
                    <a class="text-muted small" href="/settings">
                        {{ $t('title.settings') }}
                    </a>
                </li>
                <li class="d-none d-sm-inline-block">
                    <a href="#" @click.prevent="showZenDesk" class="text-muted small">
                        {{ $t('title.help') }}
                    </a>
                </li>
                <li>
                    <app-logout></app-logout>
                </li>
            </ul>

        </div>

        <modal v-if="newAccount.modalVisible" @close="hideNewAccountModal" :title="$t('action.new.account')">
            <form slot="body"
                  @submit.stop.prevent="createAccount"
                  :class="[{'was-validated': newAccount.validated}]"
                  data-vv-scope="newAccount"
                  novalidate>
                <div class="form-group">
                    <label for="name" v-html="$t('form.name')"></label>
                    <input id="name" type="text" class="form-control"
                           v-model="newAccount.name"
                           v-focus
                           v-validate="'required'"
                           ref="newAccountInput"
                           data-vv-name="name"
                           :data-vv-as="$t('form.name')">
                    <span class="invalid-feedback">{{ errors.first('newAccount.name') }}</span>
                </div>
            </form>
            <div slot="footer">
                <button class="btn btn-light" v-on:click="hideNewAccountModal">
                    {{ $t('action.cancel') }}
                </button>
                <button class="btn btn-primary" v-on:click="createAccount">
                    {{ $t('action.save') }}
                </button>
            </div>
        </modal>
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
                validated: false,
                modalVisible: false
            }
        }),
        computed: {
            user() {
                return this.$store.state.user;
            },
            ...mapGetters([
                'sortedAccounts',
                'sortedAccounts'
            ])
        },
        mounted() {
            let menu = this.$el;

            menu.addEventListener("transitionend", function () {
                menu.classList.remove("menu--animatable");
            }, false);
        },
        methods: {

            showNewAccountModal() {
                // Hide menu
                this.hideMenu();

                // Reset Validation
                this.newAccount.validated = false;
                this.errors.clear('newAccount');

                // Reset Data
                this.newAccount.name = '';

                // Show modal
                this.newAccount.modalVisible = true;
            },
            hideNewAccountModal() {
                // Hide Modal
                this.newAccount.modalVisible = false;
            },
            createAccount() {
                this.$validator.validateAll('newAccount').then(isValid => {
                    this.newAccount.validated = true;

                    if (isValid) {
                        this.$store.dispatch('createAccount', this.newAccount);
                        this.hideNewAccountModal();
                    }
                });
            },
            hideMenu() {
                let menu = this.$el;
                if (menu.classList.contains("menu--visible")) {
                    menu.classList.add("menu--animatable");
                    menu.classList.remove('menu--visible');
                }
            },
            showZenDesk() {
                this.hideMenu();
                window.zE.activate({hideOnClose: true});
            }
        }
    }
</script>