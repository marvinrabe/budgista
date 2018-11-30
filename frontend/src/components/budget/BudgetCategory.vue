<template>
    <div class="budget-row">
        <div class="handle budget-row-handle">
            <span class="small text-dark">
                <font-awesome-icon icon="arrows-alt-v" fixed-width/>
            </span>
        </div>
        <div class="data" @click.stop="$refs.budgetInput.focus()">
            <div class="budget-column-name">
                <ellipsis>{{ category.name }}</ellipsis>
            </div>
            <div class="budget-column-budget" @click.stop="">
                <app-skeleton :busy="loading">
                    <app-money-input ref="budgetInput"
                                     :value="budgeted"
                                     :title="$t('form.recommendedBudget')+': '+$moneyFormatter().format(recommendedBudget)"
                                     @change="val => updateBudget(val)"></app-money-input>
                </app-skeleton>
            </div>
            <div class="budget-column-activity">
                <app-skeleton :busy="loading">
                    <money-format :value="activity"></money-format>
                </app-skeleton>
            </div>
            <div class="budget-column-available">
                <app-skeleton :busy="loading">
                    <money-format :class="[{ 'text-danger': available < 0 }, { 'text-success': available > 0 }]"
                                  :value="available"></money-format>
                </app-skeleton>
            </div>
        </div>
        <div class="actions">
            <category-settings :category="category"></category-settings>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .budget-row {
        .data {
            cursor: pointer;
        }
    }
</style>

<script>
    import CategorySettings from '../categories/CategorySettings'
    import AppMoneyInput from '../form/AppMoneyInput'
    import AppSkeleton from '../AppSkeleton'

    export default {
        props: ['category', 'month', 'loading'],
        components: {
            AppMoneyInput,
            AppSkeleton,
            CategorySettings
        },
        computed: {
            row() {
                return this.$store.getters['budgets/getRow'](this.month, this.category.id)
            },
            previousMonth() {
                return this.row.previousMonth
            },
            budgeted() {
                return this.row.budget
            },
            recommendedBudget() {
                return this.row.recommendedBudget
            },
            activity() {
                return this.row.activity
            },
            available() {
                return this.row.available
            }
        },
        methods: {
            updateBudget: function (value) {
                this.$store.dispatch('budgets/update', {
                    ...this.row,
                    budget: value
                })
            }
        }
    }
</script>
