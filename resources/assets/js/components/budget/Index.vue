<template>
    <div class="main">

        <app-toolbar :title="$t('title.budget')">
            <div slot="title" class="d-flex">
                <a href="#" class="text-light small"
                   :title="$t('action.previousMonth')"
                   @click.prevent.stop="showPreviousMonth">
                    <font-awesome-icon icon="chevron-left"/>
                </a>
                <date-format
                        :value="month"
                        class="mx-1"
                        :options="{year: 'numeric', month: 'short'}">
                </date-format>
                <a href="#" class="text-light small"
                   :title="$t('action.nextMonth')"
                   @click.prevent.stop="showNextMonth">
                    <font-awesome-icon icon="chevron-right"/>
                </a>
            </div>

            <div class="d-none d-sm-block ml-auto">
                <transition name="fade">
                    <div class="d-flex align-items-center" v-if="!loading">
                        <div class="d-none d-lg-block kpi small mr-2">
                            <money-format
                                    class="font-weight-bold"
                                    :value="sheet.previousMonth">
                            </money-format>
                            <br>
                            <span class="kpi-label">{{ $t('form.previousMonth') }}</span>
                        </div>
                        <div class="d-none d-lg-block kpi small mr-2">
                            <money-format
                                    class="font-weight-bold"
                                    :value="sheet.income">
                            </money-format>
                            <br>
                            <span class="kpi-label">{{ $t('form.income') }}</span>
                        </div>
                        <div class="d-none d-lg-block kpi small mr-2">
                            <money-format
                                    class="font-weight-bold"
                                    :value="sheet.allocated">
                            </money-format>
                            <br>
                            <span class="kpi-label">{{ $t('form.allocated') }}</span>
                        </div>

                        <div class="mr-1 badge"
                             :class="[{ 'badge-danger': unallocated < 0 }, { 'badge-success': unallocated >= 0 }]">
                            <money-format
                                    class="h4 p-2 text-number"
                                    :value="unallocated">
                            </money-format>
                            <br>
                            <span class="small">{{ $t('form.unallocated') }}</span>
                        </div>
                    </div>
                </transition>
            </div>

            <div style="flex: 100%; align-items: center;" class="d-flex d-sm-none p-2"
                 :class="[{ 'bg-danger': unallocated < 0 }, { 'bg-success': unallocated >= 0 }]">
                <div class="col-flex text-left small">
                    {{ $t('form.unallocated') }}
                </div>
                <div class="col-flex text-right" v-if="!loading">
                    <money-format
                            class="h5 mb-0 text-number"
                            :value="unallocated">
                    </money-format>
                </div>
                <div class="col-flex text-right" v-else>
                    <span class="h5 mb-0">&nbsp;</span>
                </div>
            </div>

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

            <app-spinner v-if="loading"></app-spinner>
        </div>

    </div>
</template>

<style>
    .kpi {
        text-align: center;
    }

    .kpi-label {
        opacity: .8;
    }
</style>

<script>
    import row from './Row.vue'

    export default {
        components: {
            'category-row': row
        },
        computed: {
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
            month: new Date().getFullYear() + '-' + (new Date().getMonth() + 1),
            rows: [],
            previousMonth: null,
            nextMonth: null
        }),

        mounted() {
            this.loadSheet('/api/month');
        },

        methods: {
            loadSheet(url) {
                this.loading = true;
                this.rows = [];

                axios
                    .get(url)
                    .then(response => {
                        // JSON responses are automatically parsed.
                        this.loading = false;
                        this.sheet = response.data.data;
                        this.month = this.sheet.month;
                        this.rows = this.sheet.rows;
                        this.previousMonth = response.data.links.prev;
                        this.nextMonth = response.data.links.next;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            showPreviousMonth() {
                let currentDate = new Date(this.month);
                let newDate = new Date(currentDate.setMonth(currentDate.getMonth() - 1));
                this.month = newDate.getFullYear() + '-' + (newDate.getMonth() + 1);

                this.loadSheet(this.previousMonth);
            },

            showNextMonth() {
                let currentDate = new Date(this.month);
                let newDate = new Date(currentDate.setMonth(currentDate.getMonth() + 1));
                this.month = newDate.getFullYear() + '-' + (newDate.getMonth() + 1);

                this.loadSheet(this.nextMonth);
            }

        }
    }
</script>