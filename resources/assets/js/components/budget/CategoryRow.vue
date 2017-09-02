<template>
    <tr>
        <td>
            <a class="link-action text-dark" :title="$t('action.edit.category')">
                {{ category.name }}
            </a>
        </td>
        <td class="text-right">
            <a class="link-action"
               v-bind:class="[{ 'text-muted': category.budgeted == 0 }, 'text-dark']"
               v-html="$formatNumber(category.budgeted, {style: 'currency', currency: currency})">
            </a>
        </td>
        <td class="text-right"
            v-bind:class="[{ 'text-muted': category.activity == 0 }, 'text-dark']"
            v-html="$formatNumber(category.activity, {style: 'currency', currency: currency})">
        </td>
        <td class="text-right">
                <span style="font-size: 100%" class="badge"
                      v-bind:class="[{ 'badge-danger': category.available < 0 }, { 'badge-success': category.available > 0 }, 'badge-secondary']"
                      v-html="$formatNumber(category.available, {style: 'currency', currency: currency})">
                </span>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['category'],
        computed: {
            currency: function () {
                return window.currency;
            }
        }
    }
</script>