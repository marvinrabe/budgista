<template>
    <div id="wrapper">
        <div id="loading" v-if="loading">
            <app-spinner></app-spinner>
        </div>
        <div id="layout" v-else>
            <app-sidebar></app-sidebar>

            <router-view :key="$router.fullPath"></router-view>
        </div>
        <vue-snotify></vue-snotify>
    </div>
</template>

<style scoped>
    #wrapper, #loading, #layout {
        height: 100%;
    }

    #loading {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    import AppSidebar from '../AppSidebar'

    export default {
        components: {AppSidebar},
        computed: {
            loading () {
                return this.$store.state.loading;
            }
        },
        mounted () {
            this.$store.dispatch('initialize');
        }
    }
</script>