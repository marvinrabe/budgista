<template>
    <div class="main">

        <app-toolbar :title="$t('title.budget')">
            <month-picker :month="monthObject" slot="title"></month-picker>

            <overview :sheet="sheet" :loading="loading"></overview>

            <template slot="submenu">
                <budget-settings :month="monthObject"></budget-settings>
            </template>
        </app-toolbar>

        <budget v-model="rows"
                :loading="loading"
                :month="month"></budget>

    </div>
</template>

<script>
    import Month from '../../models/Month.js'
    import MonthPicker from './MonthPicker'
    import Overview from './Overview'
    import Budget from './Budget'
    import BudgetSettings from './BudgetSettings'

    export default {
        props: ['month'],
        components: {
            Budget,
            BudgetSettings,
            MonthPicker,
            Overview
        },
        computed: {
            monthObject() {
                return Month.fromString(this.month)
            },
            allocated: function () {
                let sum = 0
                this.rows.forEach(function (row) {
                    sum += row.budget
                })
                return sum
            },
            unallocated: function () {
                return this.budget.previousMonth + this.budget.income - this.allocated
            },
            sheet: function () {
                return {
                    income: this.budget.income,
                    allocated: this.allocated,
                    unallocated: this.unallocated,
                    previousMonth: this.budget.previousMonth
                }
            }
        },
        data: () => ({
            budget: {
                income: 0,
                previousMonth: 0
            },
            loading: true,
            rows: []
        }),

        mounted() {
            this.loadSheet()
        },

        beforeRouteUpdate(to, from, next) {
            this.loadSheet(to.params.month)
            next()
        },

        methods: {
            reset() {
                this.budget = {
                    income: 0,
                    previousMonth: 0
                }
                this.loading = true
                this.rows = []
            },
            loadSheet(month) {
                this.reset()

                axios
                    .get('/month/' + (month || this.month))
                    .then(({data}) => {
                        this.loading = false
                        this.budget = data.data
                        this.rows = data.data.rows
                        this.previousMonth = data.links.prev
                        this.nextMonth = data.links.next
                    })
            }

        }
    }
</script>
