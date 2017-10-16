<template>
    <div id="layout">
        <app-sidebar></app-sidebar>

        <router-view :key="$router.fullPath"></router-view>
    </div>
</template>

<script>
    export default {
        props: ['budgetId'],
        created: function () {
            this.$store.dispatch('initialize', this.budgetId);
        }
    }
</script>