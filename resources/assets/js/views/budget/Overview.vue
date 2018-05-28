<template>
    <div class="overview">
        <app-number :value="sheet.previousMonth" label="form.previousMonth" class="d-none d-sm-flex"></app-number>
        <app-number :value="sheet.income" label="form.income" class="d-none d-sm-flex"></app-number>
        <app-number :value="sheet.unallocated" label="form.unallocated" :color="true"></app-number>
    </div>
</template>

<style scoped>
    .overview {
        margin: 0 -.5em;
        display: flex;
    }
</style>

<script>
    import AppNumber from '../../components/AppNumber'

    export default {
        props: ['sheet'],
        components: {
            AppNumber
        }
    }
</script>