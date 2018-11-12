<template>
    <div class="main">
        <app-toolbar :title="$t('title.statistics')"/>

        <net-worth></net-worth>
    </div>
</template>

<script>
    import NetWorth from './NetWorth'

    export default {
        components: {
            NetWorth
        }
    }
</script>
