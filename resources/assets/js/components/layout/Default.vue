<template>
    <div id="wrapper">
        <div id="loading" v-if="loading">
            <app-spinner></app-spinner>
        </div>
        <div id="layout" v-else>
            <app-header></app-header>

            <div class="container py-3">
                <div class="form-row">
                    <div class="col-md-4 col-xl-3">
                        <app-sidebar></app-sidebar>
                    </div>
                    <div class="col-12 col-md-8 col-xl-9">
                        <router-view :key="$router.fullPath"></router-view>
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

    export default {
        components: {
            AppHeader,
            AppSidebar
        },
        computed: {
            loading() {
                return this.$store.state.loading
            }
        },
        mounted() {
            this.$store.dispatch('initialize')
        }
    }
</script>