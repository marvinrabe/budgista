<template>
    <tr>
        <td>
            <a class="link-action text-dark" :title="$t('action.edit.category')">
            {{ category.name }}
            </a>
        </td>
        <category-budget
                :value="category.budgeted"
                v-on:update:value="val => updateBudget(val)">
        </category-budget>
        <td class="d-none d-md-table-cell text-right"
            v-bind:class="[{ 'text-muted': category.activity == 0 }, 'text-dark']"
            v-html="$formatNumber(category.activity, {style: 'currency', currency: currency})">
        </td>
        <td class="text-right">
                <span style="font-size: 100%" class="badge"
                      v-bind:class="[{ 'badge-danger': available < 0 }, { 'badge-success': available > 0 }, 'badge-secondary']"
                      v-html="$formatNumber(available, {style: 'currency', currency: currency})">
                </span>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['category'],
        components: {
            'category-budget': require('./CategoryBudget.vue')
        },
        computed: {
            available: function () {
                return this.category.previousMonth + this.category.budgeted + this.category.activity;
            },
            currency: function () {
                return window.currency;
            }
        },
        methods: {
            updateBudget: function (value) {
                this.category.budgeted = value;

                axios
                    .put('/api/categories/' + this.category.id + '/budget', {
                        'month': this.category.month,
                        'amount': value
                    })
                    .then(response => {
                        this.$emit('update:category', response.data);
                    })
                    .catch(e => {
                        console.error(e);
                    });

            }
        }
    }
</script>