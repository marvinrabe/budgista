<template>
    <div class="overview">
        <app-number :value="sheet.previousMonth" label="form.previousMonth" class="d-none d-lg-flex"></app-number>
        <app-number :value="sheet.income" label="form.income"></app-number>
        <app-number :value="sheet.allocated" label="form.allocated"></app-number>
        <app-number :value="sheet.unallocated" label="form.unallocated" :color="true"></app-number>
    </div>
</template>

<style scoped>
    .overview {
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