<template>
    <div>

        <div class="navbar text-light row d-lg-none" v-bind:class="[{ 'bg-danger': sheet.available < 0 }, 'bg-success']">
            <div class="col">
                <strong>{{ trans('form.toBeBudgeted') }}</strong>
            </div>
            <div class="col text-right" v-html="$formatNumber(sheet.available, {style: 'currency', currency: currency})"></div>
        </div>

        <div class="d-none d-lg-flex form-row mb-3" style="align-items: flex-end;">
            <div class="col-6">
                <div class="h3 display-4 mb-0">
                    <a class="btn btn-secondary rounded-circle"
                       href="" :title="trans('action.previousMonth')">
                        <span class="fa fa-chevron-left"></span>
                    </a>
                    {{ sheet.month }}
                    <a class="btn btn-secondary rounded-circle"
                       href="" :title="trans('action.nextMonth')">
                        <span class="fa fa-chevron-right"></span>
                    </a>
                </div>
            </div>
            <div class="col text-right">
                <div class="badge" v-bind:class="[{ 'badge-danger': sheet.available < 0 }, 'badge-success']">
                    <strong class="h3" v-html="$formatNumber(sheet.available, {style: 'currency', currency: currency})"></strong><br>
                    <span class="small">{{ trans('form.toBeBudgeted') }}</span>
                </div>
            </div>
            <div class="col small">
                {{ trans('form.previousMonth') }}: <strong v-html="$formatNumber(sheet.previousMonth, {style: 'currency', currency: currency})"></strong><br>
                {{ trans('form.funds') }}: <strong v-html="$formatNumber(sheet.funds, {style: 'currency', currency: currency})"></strong><br>
                {{ trans('form.budgeted') }}: <strong v-html="$formatNumber(sheet.budgeted, {style: 'currency', currency: currency})"></strong>
            </div>
        </div>


        <table class="table table-sm">
            <thead>
            <tr>
                <th>{{ trans('form.category') }}</th>
                <th class="text-right">{{ trans('form.budgeted') }}</th>
                <th class="text-right">{{ trans('form.activity') }}</th>
                <th class="text-right">{{ trans('form.available') }}</th>
            </tr>
            </thead>
            <tr v-for="row in sheet.rows">
                <td>
                    <a class="text-dark" href="" :title="trans('action.edit.category')">
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
</template>

<script>
    export default {
        props: ['sheet'],
        computed: {
            currency: function () {
                return window.currency;
            }
        }
    }
</script>