<template>
    <div class="main">

        <app-toolbar :title="$t('title.budget')">
            <month-picker :month="monthObject" slot="title"></month-picker>

            <div class="d-none d-sm-block ml-auto">
                <transition name="fade">
                    <div class="d-flex align-items-center small" v-if="!loading">
                        <div class="d-none d-lg-block kpi mr-2">
                            <money-format
                                    class="font-weight-bold text-number"
                                    :value="sheet.previousMonth">
                            </money-format>
                            <br>
                            <span class="kpi-label">{{ $t('form.previousMonth') }}</span>
                        </div>
                        <div class="d-none d-lg-block kpi mr-2">
                            <money-format
                                    class="font-weight-bold text-number"
                                    :value="sheet.income">
                            </money-format>
                            <br>
                            <span class="kpi-label">{{ $t('form.income') }}</span>
                        </div>
                        <div class="d-none d-lg-block kpi">
                            <money-format
                                    class="font-weight-bold text-number"
                                    :value="allocated">
                            </money-format>
                            <br>
                            <span class="kpi-label">{{ $t('form.allocated') }}</span>
                        </div>

                        <div class="kpi mr-1 py-1 px-2 rounded"
                             :class="[{ 'bg-danger': unallocated < 0 }, { 'bg-success': unallocated > 0 }]">
                            <money-format
                                    class="font-weight-bold text-number"
                                    :value="unallocated">
                            </money-format>
                            <br>
                            <span class="kpi-label">{{ $t('form.unallocated') }}</span>
                        </div>
                    </div>
                </transition>
            </div>
        </app-toolbar>

        <transition name="slide">
            <div class="d-sm-none"
                 v-if="unallocated !== 0"
                 :class="[{ 'bg-danger': unallocated < 0 }, { 'bg-success': unallocated > 0 }]">
                <div class="d-flex small text-white p-2">
                    <div class="col-flex text-left">
                        {{ $t('form.unallocated') }}
                    </div>
                    <div class="col-flex text-right" v-if="!loading">
                        <money-format
                                class="font-weight-bold text-number"
                                :value="unallocated">
                        </money-format>
                    </div>
                </div>
            </div>
        </transition>

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

            <app-spinner v-if="loading"></app-spinner>
        </div>

    </div>
</template>

<style>
    .kpi {
        margin-right: 1em;
        padding: 0 1em;
        text-align: right;
    }

    .kpi-label {
        opacity: .8;
    }
</style>

<script>
    import row from './Row.vue'
    import Month from '../../models/Month.js'
    import MonthPicker from './MonthPicker'

    export default {
        props: ['month'],
        components: {
            'category-row': row,
            MonthPicker
        },
        computed: {
            monthObject() {
                return Month.fromString(this.month);
            },
            allocated: function () {
                let sum = 0;
                this.rows.forEach(function (row) {
                    sum += row.budget;
                });
                return sum;
            },
            unallocated: function () {
                return this.sheet.previousMonth + this.sheet.income - this.allocated;
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
            this.loadSheet();
        },

        beforeRouteUpdate(to, from, next) {
            this.loadSheet(to.params.month);
            next();
        },

        methods: {
            reset() {
                this.sheet = {
                    income: 0,
                    allocated: 0,
                    previousMonth: 0
                };
                this.loading = true;
                this.rows = [];
            },
            loadSheet(month) {
                this.reset();

                axios
                    .get('/api/month/' + (month || this.month))
                    .then(({data}) => {
                        this.loading = false;
                        this.sheet = data.data;
                        this.rows = this.sheet.rows;
                        this.previousMonth = data.links.prev;
                        this.nextMonth = data.links.next;
                    })
            }

        }
    }
</script>