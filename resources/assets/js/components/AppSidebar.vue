<template>
    <div class="menu" @click="hideMenu">
        <div class="app-menu py-3 py-md-0" @click.stop>
            <nav class="nav flex-column flex-nowrap">
                <template v-for="item in menu">
                    <div class="my-2" v-if="item.accounts">
                        <div class="d-flex align-items-center">
                            <p class="nav-header">{{ $t('title.accounts') }}</p>
                            <button class="ml-auto btn btn-light btn-sm text-muted"
                                    type="button"
                                    :title="$t('action.create.account')"
                                    @click="showNewAccountModal">
                                <font-awesome-icon icon="plus"/>
                            </button>
                        </div>

                        <account-menu-item
                                v-for="account in spendingAccounts"
                                :key="account.id"
                                :account="account"
                                @click.native="hideMenu">
                        </account-menu-item>
                        <template v-if="trackingAccounts.length">
                            <p class="nav-header mt-2">{{ $t('title.trackingAccounts') }}</p>
                            <account-menu-item
                                    v-for="account in trackingAccounts"
                                    :key="account.id"
                                    :account="account"
                                    @click.native="hideMenu">
                            </account-menu-item>
                        </template>
                    </div>
                    <router-link
                            v-else-if="item.route"
                            :to="item.route"
                            @click.native="hideMenu"
                            active-class="active"
                            :exact="!!item.exact"
                            class="nav-link-main"
                            :class="item.class">
                        <font-awesome-icon :icon="item.icon" v-if="item.icon" fixed-width class="mr-1"/>
                        <span class="d-block mr-1" style="width: 1.25em" v-else></span>
                        <span class="nav-link-main-label">{{ $t(item.label) }}</span>
                    </router-link>
                    <a v-else-if="item.click" href="#" class="nav-link-main" @click.prevent="item.click"
                       :class="item.class">
                        <font-awesome-icon :icon="item.icon" v-if="item.icon" fixed-width class="mr-1"/>
                        <span class="d-block mr-1" style="width: 1.25em" v-else></span>
                        <span class="nav-link-main-label">{{ $t(item.label) }}</span>
                    </a>
                    <a v-else :href="item.href" class="nav-link-main" :class="item.class">
                        <font-awesome-icon :icon="item.icon" v-if="item.icon" fixed-width class="mr-1"/>
                        <span class="d-block mr-1" style="width: 1.25em" v-else></span>
                        <span class="nav-link-main-label">{{ $t(item.label) }}</span>
                    </a>
                </template>

                <create-account ref="createAccount"></create-account>
            </nav>
        </div>
    </div>
</template>

<script>
    import AppLogo from './AppLogo.vue'
    import AccountMenuItem from './accounts/MenuItem'
    import CreateAccount from './accounts/CreateAccount'
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faEnvelope from '@fortawesome/fontawesome-free-solid/faEnvelope'
    import faThLarge from '@fortawesome/fontawesome-free-solid/faThLarge'
    import faCog from '@fortawesome/fontawesome-free-solid/faCog'
    import faLifeRing from '@fortawesome/fontawesome-free-solid/faLifeRing'
    import {mapGetters} from 'vuex'

    export default {
        components: {
            AppLogo,
            AccountMenuItem,
            CreateAccount,
            FontAwesomeIcon
        },
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
                        route: {name: 'settings.general'},
                        label: 'title.settings',
                        icon: faCog,
                        class: 'd-md-none'
                    },
                    {
                        href: 'mailto:support@budgista.com',
                        label: 'title.help',
                        icon: faLifeRing,
                        class: 'd-md-none'
                    },
                    {
                        click: this.logout,
                        label: 'action.logout',
                        class: 'd-md-none'
                    }
                ]
            },
            ...mapGetters([
                'spendingAccounts',
                'trackingAccounts'
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

                // Show modal
                this.$refs.createAccount.showModal()
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
                    success: function () {
                        this.$store.dispatch('RESET')
                    },
                    redirect: {name: 'login'}
                })
            }
        }
    }
</script>