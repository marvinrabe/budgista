<template>
    <div class="main">

        <app-toolbar :title="$t('title.budget')">
            <month-picker :month="monthObject" slot="title"></month-picker>

            <transition name="fade">
                <overview :sheet="sheet" v-if="!loading"></overview>
            </transition>

            <template slot="submenu">
                <budget-settings :month="monthObject"></budget-settings>
            </template>
        </app-toolbar>

        <app-spinner v-if="loading"></app-spinner>

        <budget-table
                v-model="rows"
                :month="month"
                v-else>
        </budget-table>

    </div>
</template>

<script>
    import Month from '../../models/Month.js'
    import MonthPicker from './MonthPicker'
    import Overview from './Overview'
    import BudgetSettings from './BudgetSettings'
    import BudgetTable from './BudgetTable'

    export default {
        props: ['month'],
        components: {
            BudgetSettings,
            BudgetTable,
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