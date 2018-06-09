<template>
    <div class="main">

        <app-toolbar :title="$t('title.budget')">
            <month-picker :month="monthObject" slot="title"></month-picker>

            <transition name="fade">
                <overview :sheet="sheet" v-if="!loading"></overview>
            </transition>
        </app-toolbar>

        <div class="budget-header">
            <div class="budget-column-name">
                {{ $t('form.category') }}
            </div>
            <div class="budget-column-values">
                <div class="budget-column-budget">
                    {{ $t('form.budget') }}
                </div>
                <div class="budget-column-activity">
                    {{ $t('form.activity') }}
                </div>
                <div class="budget-column-available">
                    {{ $t('form.available') }}
                </div>
            </div>
        </div>

        <div class="content">
            <category-row
                    v-for="(row, index) in rows"
                    :key="month+'#'+row.id"
                    :month="month"
                    :value="row"
                    @update:value="val => rows.splice(index, 1, val)"/>
        </div>

        <app-spinner v-if="loading"></app-spinner>

    </div>
</template>

<script>
    import row from './Row.vue'
    import Month from '../../models/Month.js'
    import MonthPicker from './MonthPicker'
    import Overview from './Overview'

    export default {
        props: ['month'],
        components: {
            'category-row': row,
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
                return this.sheet.previousMonth + this.sheet.income - this.allocated
            }
        },
        data: () => ({
            sheet: {
                income: 0,
                allocated: 0,
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
                this.sheet = {
                    income: 0,
                    allocated: 0,
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
                        this.sheet = data.data
                        this.rows = this.sheet.rows
                        this.previousMonth = data.links.prev
                        this.nextMonth = data.links.next
                    })
            }

        }
    }
</script>