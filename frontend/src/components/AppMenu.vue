<template>
    <div class="menu">
        <template v-for="item in menu">
            <account-menu v-if="item.accounts"
                          @navigate="$emit('navigate')">
            </account-menu>
            <router-link
                    v-else-if="item.route"
                    :to="item.route"
                    @click.native="$emit('navigate')"
                    active-class="active"
                    :exact="!!item.exact"
                    class="menu__item"
                    :class="item.class">
                <font-awesome-icon :icon="item.icon" v-if="item.icon" fixed-width class="mr-1"/>
                <span class="d-block mr-1" style="width: 1.25em" v-else></span>
                <span>{{ $t(item.label) }}</span>
            </router-link>
            <a v-else-if="item.click" href="#" class="menu__item" @click.prevent="item.click"
               :class="item.class">
                <font-awesome-icon :icon="item.icon" v-if="item.icon" fixed-width class="mr-1"/>
                <span class="d-block mr-1" style="width: 1.25em" v-else></span>
                <span>{{ $t(item.label) }}</span>
            </a>
            <a v-else :href="item.href" class="menu__item" :class="item.class">
                <font-awesome-icon :icon="item.icon" v-if="item.icon" fixed-width class="mr-1"/>
                <span class="d-block mr-1" style="width: 1.25em" v-else></span>
                <span>{{ $t(item.label) }}</span>
            </a>
        </template>
    </div>
</template>

<script>
    import AccountMenu from './accounts/Menu'
    import CreateAccount from './accounts/CreateAccount'
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
    import {faEnvelope, faCog, faLifeRing, faUserCircle, faChartBar} from '@fortawesome/free-solid-svg-icons'

    export default {
        components: {
            AccountMenu,
            CreateAccount,
            FontAwesomeIcon
        },
        computed: {
            menu() {
                return [
                    {
                        route: {name: 'budget_default'},
                        exact: false,
                        icon: faEnvelope,
                        label: 'title.budget'
                    },
                    {
                        route: {name: 'statistics'},
                        icon: faChartBar,
                        label: 'title.statistics'
                    },
                    {
                        accounts: true
                    },
                    {
                        route: {name: 'profile'},
                        label: 'title.profile',
                        icon: faUserCircle,
                        class: 'd-md-none'
                    },
                    {
                        route: {name: 'settings'},
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
            }
        },
        methods: {
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
