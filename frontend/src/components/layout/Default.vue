<template>
    <div id="wrapper">
        <div id="layout">
            <app-header></app-header>

            <div class="container py-3">
                <verify-alert></verify-alert>

                <div class="form-row">
                    <div class="col-md-4 col-xl-3">
                        <app-sidebar></app-sidebar>
                    </div>
                    <div class="col-12 col-md-8 col-xl-9">
                        <div id="loading" v-if="loading">
                            <app-spinner></app-spinner>
                        </div>
                        <router-view v-else :key="$router.fullPath"></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    #wrapper, #loading, #layout {
        height: 100%;
    }

    #layout {
        padding-top: 56px;
    }

    #loading {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    import AppHeader from '../AppHeader'
    import AppSidebar from '../AppSidebar'
    import AppSpinner from '../AppSpinner'
    import VerifyAlert from '../auth/VerifyAlert'

    export default {
        components: {
            AppHeader,
            AppSidebar,
            AppSpinner,
            VerifyAlert
        },
        computed: {
            loading() {
                return !this.$auth.ready() || this.$store.state.loading
            }
        },
        created() {
            this.$store.dispatch('initialize')
        }
    }
</script>
