<template>
    <nav class="navbar navbar-light fixed-top bg-white">
        <div class="container">
            <div class="d-md-none mr-auto">
                <app-sidebar-toggle></app-sidebar-toggle>
            </div>

            <app-logo class="navbar-brand" :height="40"></app-logo>

            <ul class="nav ml-auto">
                <li class="nav-item d-none">
                    <button class="btn btn-text-dark">
                        <font-awesome-icon :icon="iconPlus"></font-awesome-icon>
                    </button>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <b-dropdown variant="text-dark" right>
                        <template slot="button-content">
                            <font-awesome-icon :icon="iconUser"></font-awesome-icon>
                        </template>
                        <div v-for="item in menu" :key="item.label">
                            <b-dropdown-divider v-if="item.divider"></b-dropdown-divider>
                            <b-dropdown-item v-else @click="item.click">
                                {{ $t(item.label) }}
                                <span class="d-block text-muted"
                                      v-if="item.sublabel"
                                      v-text="item.sublabel"></span>
                            </b-dropdown-item>
                        </div>
                    </b-dropdown>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    import AppLogo from './AppLogo'
    import AppSidebarToggle from './AppSidebarToggle'
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'
    import bDropdownDivider from 'bootstrap-vue/es/components/dropdown/dropdown-divider'
    import {faPlus, faUserCircle} from '@fortawesome/free-solid-svg-icons'

    export default {
        components: {
            AppLogo,
            AppSidebarToggle,
            bDropdown,
            bDropdownItem,
            bDropdownDivider,
            FontAwesomeIcon
        },
        computed: {
            menu() {
                return [
                    {
                        click: this.profile,
                        label: 'title.profile',
                        sublabel: this.$store.state.user.email
                    },
                    {
                        divider: true
                    },
                    {
                        click: this.settings,
                        label: 'title.settings'
                    },
                    {
                        click: this.email,
                        label: 'title.help'
                    },
                    {
                        divider: true
                    },
                    {
                        click: this.logout,
                        label: 'action.logout'
                    }
                ]
            },
            iconPlus() {
                return faPlus
            },
            iconUser() {
                return faUserCircle
            }
        },
        methods: {
            logout() {
                this.$auth.logout({
                    makeRequest: true,
                    success: function () {
                        this.$store.commit('RESET')
                    },
                    redirect: {name: 'login'}
                })
            },
            settings() {
                this.$router.push({name: 'settings'})
            },
            profile() {
                this.$router.push({name: 'profile'})
            },
            email() {
                window.location = 'mailto:support@budgista.com'
            }
        }
    }
</script>
