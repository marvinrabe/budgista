<template>
    <div class="overview">
        <app-number :value="previousMonth" :loading="loading" label="form.previousMonth"
                    class="d-none d-sm-flex"></app-number>
        <app-number :value="income" :loading="loading" label="form.income" class="d-none d-sm-flex"></app-number>
        <app-number :value="unallocated" :loading="loading" label="form.unallocated" :color="true"></app-number>
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
        props: {
            month: {
                type: Object
            },
            loading: {
                type: Boolean,
                default: false
            }
        },
        components: {
            AppNumber
        },
        computed: {
            budget() {
                return this.$store.getters['budgets/byMonth'](this.month)
            },
            previousMonth() {
                return this.budget ? this.budget.previousMonth : 0
            },
            income() {
                return this.budget ? this.budget.income : 0
            },
            unallocated() {
                return this.budget ? this.budget.unallocated : 0
            }
        }
    }
</script>
