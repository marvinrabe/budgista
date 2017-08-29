<template>
    <table class="table table-sm">
        <thead>
        <tr>
            <th>{{ trans('form.category') }}</th>
            <th class="text-right">{{ trans('form.budgeted') }}</th>
            <th class="text-right">{{ trans('form.activity') }}</th>
            <th class="text-right">{{ trans('form.available') }}</th>
        </tr>
        </thead>
        <tr v-for="row in rows">
            <td>
                <a class="text-dark" href="" :title="trans('action.edit.category')">
                    {{ row.name }}
                </a>
            </td>
            <td class="text-right">
                <a href="" v-bind:class="[{ 'text-muted': row.budgeted == 0 }, 'text-dark']">
                    {{ row.budgeted }}
                </a>
            </td>
            <td class="text-right" v-bind:class="[{ 'text-muted': row.activity == 0 }, 'text-dark']">
                {{ row.activity }}
            </td>
            <td class="text-right">
                <span style="font-size: 100%" class="badge" v-bind:class="[{ 'badge-danger': row.available < 0 }, { 'badge-success': row.available > 0 }, 'badge-secondary']">
                    {{ row.available }}
                </span>
            </td>
        </tr>
    </table>
</template>

<script>
    export default {
        props: ['rows']
    }
</script>