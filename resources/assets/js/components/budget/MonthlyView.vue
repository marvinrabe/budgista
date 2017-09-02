<template>
    <div>
        <div v-if="sheet !== null">

            <div class="form-row mb-3" style="align-items: flex-end;">
                <div class="col-12 col-lg-6">
                    <div class="h3 display-4 mb-0 text-center text-lg-left">
                        <button class="btn btn-secondary rounded-circle"
                                :title="$t('action.previousMonth')" @click="showPreviousMonth">
                            <span class="fa fa-chevron-left"></span>
                        </button>
                        {{ sheet.month }}
                        <button class="btn btn-secondary rounded-circle"
                                :title="$t('action.nextMonth')" @click="showNextMonth">
                            <span class="fa fa-chevron-right"></span>
                        </button>
                    </div>
                </div>
                <div class="col text-right">
                    <div class="badge" v-bind:class="[{ 'badge-danger': sheet.available < 0 }, 'badge-success']">
                        <strong class="h3"
                                v-html="$formatNumber(toBeBudgeted, {style: 'currency', currency: currency})"></strong><br>
                        <span class="small">{{ $t('form.toBeBudgeted') }}</span>
                    </div>
                </div>
                <div class="col small">
                    {{ $t('form.previousMonth') }}: <strong
                        v-html="$formatNumber(sheet.previousMonth, {style: 'currency', currency: currency})"></strong><br>
                    {{ $t('form.funds') }}: <strong
                        v-html="$formatNumber(sheet.funds, {style: 'currency', currency: currency})"></strong><br>
                    {{ $t('form.budgeted') }}: <strong
                        v-html="$formatNumber(budgeted, {style: 'currency', currency: currency})"></strong>
                </div>
            </div>


            <table class="table table-sm">
                <thead>
                <tr>
                    <th>
                        {{ $t('form.category') }}
                        <category-new :budget="budget" v-on:newCategory="category => sheet.rows.push(category)"></category-new>
                    </th>
                    <th class="text-right">{{ $t('form.budgeted') }}</th>
                    <th class="text-right">{{ $t('form.activity') }}</th>
                    <th class="text-right">{{ $t('form.available') }}</th>
                </tr>
                </thead>
                <tr v-for="row in sheet.rows">
                    <td>
                        <a class="text-dark" href="" :title="$t('action.edit.category')">
                            {{ row.name }}
                        </a>
                    </td>
                    <td class="text-right">
                        <a href=""
                           v-bind:class="[{ 'text-muted': row.budgeted == 0 }, 'text-dark']"
                           v-html="$formatNumber(row.budgeted, {style: 'currency', currency: currency})">
                        </a>
                    </td>
                    <td class="text-right"
                        v-bind:class="[{ 'text-muted': row.activity == 0 }, 'text-dark']"
                        v-html="$formatNumber(row.activity, {style: 'currency', currency: currency})">
                    </td>
                    <td class="text-right">
                <span style="font-size: 100%" class="badge"
                      v-bind:class="[{ 'badge-danger': row.available < 0 }, { 'badge-success': row.available > 0 }, 'badge-secondary']"
                      v-html="$formatNumber(row.available, {style: 'currency', currency: currency})">
                </span>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['budget'],
        components: {
            'category-new': require('./CategoryNew.vue')
        },
        computed: {
            currency: function () {
                return window.currency;
            },
            budgeted: function () {
                let sum = 0;
                this.sheet.rows.forEach(function (row) {
                    sum += row.budgeted;
                });
                return sum;
            },
            toBeBudgeted: function () {
                return this.sheet.previousMonth + this.sheet.funds - this.budgeted;
            }
        },
        data: () => ({
            sheet: null,
            previousMonth: null,
            nextMonth: null
        }),

        created() {
            this.loadSheet('/api/budgets/'+this.budget+'/month');
        },

        methods: {
            loadSheet(url) {
                axios
                    .get(url)
                    .then(response => {
                        // JSON responses are automatically parsed.
                        this.sheet = response.data.data;
                        this.previousMonth = response.data.links.prev;
                        this.nextMonth = response.data.links.next;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },

            showPreviousMonth() {
                this.loadSheet(this.previousMonth);
            },

            showNextMonth() {
                this.loadSheet(this.nextMonth);
            }
        }
    }
</script>