<template>
    <div class="main">

        <app-toolbar :title="$t('title.budget')">
            <month-picker :month="monthObject" slot="title"></month-picker>

            <BudgetOverview :month="monthObject" :loading="loading"/>

            <template slot="submenu">
                <budget-settings :month="monthObject"></budget-settings>
            </template>
        </app-toolbar>

        <Budget :month="monthObject" :loading="loading"/>

    </div>
</template>

<script>
    import Month from '../../models/Month.js'
    import MonthPicker from './MonthPicker'
    import Budget from './Budget'
    import BudgetOverview from './BudgetOverview'
    import BudgetSettings from './BudgetSettings'

    export default {
        props: ['month'],
        components: {
            Budget,
            BudgetOverview,
            BudgetSettings,
            MonthPicker
        },
        computed: {
            monthObject() {
                return Month.fromString(this.month)
            },
            budget: function () {
                return this.$store.getters['budgets/byMonth'](this.monthObject)
            }
        },
        data() {
            return {
                loading: true
            }
        },

        watch: {
            month: {
                immediate: true,
                handler() {
                    this.loadSheet(this.monthObject)
                }
            }
        },

        methods: {
            loadSheet(month) {
                this.loading = true

                this.$store
                    .dispatch('budgets/fetchSingle', month)
                    .then(() => {
                        this.loading = false
                    })
            }

        }
    }
</script>
