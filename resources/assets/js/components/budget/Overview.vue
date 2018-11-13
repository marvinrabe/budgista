<template>
    <div class="overview">
        <app-number :value="sheet.previousMonth" :loading="loading" label="form.previousMonth" class="d-none d-sm-flex"></app-number>
        <app-number :value="sheet.income" :loading="loading" label="form.income" class="d-none d-sm-flex"></app-number>
        <app-number :value="sheet.unallocated" :loading="loading" label="form.unallocated" :color="true"></app-number>
    </div>
</template>

<style lang="scss" scoped>
    .overview {
        display: flex;
    }
</style>

<script>
    import AppNumber from '../AppNumber'

    export default {
        props: ['sheet', 'loading'],
        components: {
            AppNumber
        }
    }
</script>
