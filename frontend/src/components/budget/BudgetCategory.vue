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
                                     @input="val => updateBudget(val)"></app-money-input>
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
    import axios from 'axios'
    import CategorySettings from '../categories/CategorySettings'
    import AppMoneyInput from '../form/AppMoneyInput'
    import AppSkeleton from '../AppSkeleton'

    export default {
        props: ['category', 'budget', 'loading'],
        components: {
            AppMoneyInput,
            AppSkeleton,
            CategorySettings
        },
        computed: {
            previousMonth() {
                return this.budget.previousMonth
            },
            budgeted() {
                return this.budget.budget
            },
            recommendedBudget() {
                return this.budget.recommendedBudget
            },
            activity() {
                return this.budget.activity
            },
            available() {
                return this.previousMonth + this.budgeted + this.activity
            }
        },
        methods: {
            updateBudget: function (value) {
                axios
                    .put('/categories/' + this.category.id + '/budget', {
                        'month': this.budget.month,
                        'amount': value
                    })
                    .then(response => {
                        this.budgeted = value
                        this.$emit('update:budget', response.data)
                    })
            }
        }
    }
</script>
