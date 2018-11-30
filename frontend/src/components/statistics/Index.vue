<template>
    <div class="main">
        <AppToolbar :title="$t('title.statistics')"/>

        <net-worth></net-worth>
    </div>
</template>

<script>
    import AppToolbar from '../AppToolbar'
    import NetWorth from './NetWorth'

    export default {
        components: {
            AppToolbar,
            NetWorth
        }
    }
</script>
