<template>
    <div class="menu" @click="hideMenu">
        <div class="app-menu" @click.stop>

            <nav class="navbar navbar-expand navbar-light justify-content-center">
                <app-logo :height="32" class="my-2"></app-logo>
            </nav>

            <nav class="nav flex-column flex-nowrap mt-2">
                <template v-for="item in menu">
                    <div class="my-2" v-if="item.accounts">
                        <p class="nav-header">{{ $t('title.accounts') }}</p>
                        <router-link
                                v-for="account in sortedAccounts" :key="account.id"
                                :to="{ name: 'account', params: { account_id: account.id }}"
                                @click.native="hideMenu"
                                active-class="active" class="nav-link-main">
                            <ellipsis style="flex: 1;">{{ account.name }}</ellipsis>
                            <money-format
                                    class="ml-auto badge"
                                    :class="[{ 'text-danger': account.workingBalance < 0, 'text-success': account.workingBalance >= 0 }]"
                                    :value="account.workingBalance">
                            </money-format>
                        </router-link>
                        <a v-on:click="showNewAccountModal" class="nav-link link-action text-muted small">
                            <font-awesome-icon icon="plus"/>
                            {{ $t('action.create.account') }}
                        </a>
                    </div>
                    <router-link
                            v-else-if="item.route"
                            :to="item.route"
                            @click.native="hideMenu"
                            active-class="active"
                            :exact="!!item.exact"
                            class="nav-link-main">
                        <font-awesome-icon :icon="item.icon" v-if="item.icon" fixed-width class="mr-1"/>
                        <span class="d-block mr-1" style="width: 1.3em" v-else></span>
                        {{ $t(item.label) }}
                    </router-link>
                    <a v-else-if="item.click" href="#" class="nav-link-main" @click.prevent="item.click">
                        <font-awesome-icon :icon="item.icon" v-if="item.icon" fixed-width class="mr-1"/>
                        <span class="d-block mr-1" style="width: 1.3em" v-else></span>
                        {{ $t(item.label) }}
                    </a>
                    <a v-else :href="item.href" class="nav-link-main">
                        <font-awesome-icon :icon="item.icon" v-if="item.icon" fixed-width class="mr-1"/>
                        <span class="d-block mr-1" style="width: 1.3em" v-else></span>
                        {{ $t(item.label) }}
                    </a>
                </template>
            </nav>

        </div>

        <modal v-if="newAccount.modalVisible" @close="hideNewAccountModal" :title="$t('action.create.account')">
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
                <button class="btn btn-text-light" v-on:click="hideNewAccountModal">
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
    import AppLogo from './AppLogo.vue'
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faEnvelope from '@fortawesome/fontawesome-free-solid/faEnvelope'
    import faThLarge from '@fortawesome/fontawesome-free-solid/faThLarge'
    import faCog from '@fortawesome/fontawesome-free-solid/faCog'
    import faLifeRing from '@fortawesome/fontawesome-free-solid/faLifeRing'
    import {mapGetters} from 'vuex'

    export default {
        components: {
            AppLogo,
            FontAwesomeIcon
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
                return this.$store.state.user
            },
            menu() {
                return [
                    {
                        route: {name: 'budget_default'},
                        exact: false,
                        icon: faEnvelope,
                        label: 'title.budget'
                    },
                    {
                        route: {name: 'categories'},
                        exact: true,
                        icon: faThLarge,
                        label: 'title.categories'
                    },
                    {
                        accounts: true
                    },
                    {
                        route: { name: 'settings.account' },
                        label: 'title.settings',
                        icon: faCog
                    },
                    {
                        href: 'mailto:support@budgista.com',
                        label: 'title.help',
                        icon: faLifeRing
                    },
                    {
                        click: this.logout,
                        label: 'action.logout',
                    }
                ]
            },
            ...mapGetters([
                'sortedAccounts',
                'sortedAccounts'
            ])
        },
        mounted() {
            let menu = this.$el

            menu.addEventListener('transitionend', function () {
                menu.classList.remove('menu--animatable')
            }, false)
        },
        methods: {

            showNewAccountModal() {
                // Hide menu
                this.hideMenu()

                // Reset Validation
                this.newAccount.validated = false
                this.errors.clear('newAccount')

                // Reset Data
                this.newAccount.name = ''

                // Show modal
                this.newAccount.modalVisible = true
            },
            hideNewAccountModal() {
                // Hide Modal
                this.newAccount.modalVisible = false
            },
            createAccount() {
                this.$validator.validateAll('newAccount').then(isValid => {
                    this.newAccount.validated = true

                    if (isValid) {
                        this.$store.dispatch('createAccount', this.newAccount)
                        this.hideNewAccountModal()
                    }
                })
            },
            hideMenu() {
                let menu = this.$el
                if (menu.classList.contains('menu--visible')) {
                    menu.classList.add('menu--animatable')
                    menu.classList.remove('menu--visible')
                }
            },
            logout() {
                this.$auth.logout({
                    makeRequest: true,
                    redirect: {name: 'login'}
                })
            }
        }
    }
</script>