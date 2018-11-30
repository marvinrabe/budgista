<template>
    <div class="main">
        <AppToolbar :title="$t('title.statistics')"/>

        <net-worth></net-worth>
    </div>
</template>

<script>
    import AppToolbar from '@/components/AppToolbar'
    import NetWorth from '@/components/statistics/NetWorth'

    export default {
        components: {
            AppToolbar,
            NetWorth
        }
    }
</script>
