<template>
    <nav class="navbar navbar-light fixed-top bg-white shadow-0">
        <div class="container">
            <div class="d-md-none mr-auto">
                <app-sidebar-toggle></app-sidebar-toggle>
            </div>

            <app-logo class="navbar-brand ml-md-3" :height="40"></app-logo>

            <ul class="nav ml-auto">
                <li class="nav-item">
                    <button class="btn btn-text-dark">
                        <font-awesome-icon :icon="iconPlus"></font-awesome-icon>
                    </button>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <button class="btn btn-text-dark dropdown-toggle">
                        <font-awesome-icon :icon="iconCog"></font-awesome-icon>
                    </button>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    import AppLogo from './AppLogo'
    import AppSidebarToggle from './AppSidebarToggle'
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faPlus from '@fortawesome/fontawesome-free-solid/faPlus'
    import faCog from '@fortawesome/fontawesome-free-solid/faCog'

    export default {
        components: {
            AppLogo,
            AppSidebarToggle,
            FontAwesomeIcon
        },
        computed: {
            iconPlus() {
                return faPlus
            },
            iconCog() {
                return faCog
            }
        }
    }
</script>