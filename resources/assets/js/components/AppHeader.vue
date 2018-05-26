<template>
    <nav class="navbar navbar-light fixed-top bg-white shadow-0">
        <div class="container">
            <div class="d-md-none mr-auto">
                <app-sidebar-toggle></app-sidebar-toggle>
            </div>

            <app-logo class="navbar-brand ml-md-3" :height="40"></app-logo>

            <ul class="nav ml-auto">
                <li class="nav-item d-none">
                    <button class="btn btn-text-dark">
                        <font-awesome-icon :icon="iconPlus"></font-awesome-icon>
                    </button>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <b-dropdown variant="text-dark" right>
                        <template slot="button-content">
                            <font-awesome-icon :icon="iconCog"></font-awesome-icon>
                        </template>
                        <div v-for="item in menu" :key="item.label">
                            <b-dropdown-divider v-if="item.divider"></b-dropdown-divider>
                            <b-dropdown-item v-else @click="item.click">
                                <font-awesome-icon :icon="item.icon" v-if="item.icon"></font-awesome-icon>
                                {{ $t(item.label) }}
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
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'
    import bDropdownDivider from 'bootstrap-vue/es/components/dropdown/dropdown-divider'
    import faPlus from '@fortawesome/fontawesome-free-solid/faPlus'
    import faCog from '@fortawesome/fontawesome-free-solid/faCog'
    import faLifeRing from '@fortawesome/fontawesome-free-solid/faLifeRing'

    export default {
        components: {
            AppLogo,
            AppSidebarToggle,
            bDropdown,
            bDropdownItem,
            bDropdownDivider,
            FontAwesomeIcon
        },
        data() {
            return {
                menu: [
                    {
                        click: this.settings,
                        label: 'title.settings',
                        icon: faCog
                    },
                    {
                        click: this.email,
                        label: 'title.help',
                        icon: faLifeRing
                    },
                    {
                        divider: true
                    },
                    {
                        click: this.logout,
                        label: 'action.logout'
                    }
                ]
            }
        },
        computed: {
            iconPlus() {
                return faPlus
            },
            iconCog() {
                return faCog
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
            },
            settings() {
                this.$router.push({name: 'settings.general'})
            },
            email() {
                window.location = 'mailto:support@budgista.com'
            }
        }
    }
</script>