<template>
    <div>
        <div class="budget-header">
            <div class="handle">&nbsp;</div>
            <div class="data">
                <div class="budget-column-name">
                    {{ $t('form.category') }}
                </div>
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
            <div class="actions">&nbsp;</div>
        </div>

        <div class="content">
            <draggable v-model="categories" :options="{handle:'.handle'}" class="list-group">
                <category-budget-row
                        v-for="category in categories"
                        :key="category.id"
                        :category="category"
                        :budget="budgetForCategory(category)"
                        @update:budget="updateBudget">
                </category-budget-row>
            </draggable>
        </div>
    </div>
</template>

<style scoped>
    .handle {
        flex: 24px;
        flex-shrink: 0;
        flex-grow: 0;
    }

    .data {
        flex: 1;
        display: flex;
    }

    .actions {
        flex: 48px;
        flex-shrink: 0;
        flex-grow: 0;
    }
</style>

<script>
    import CategoryBudgetRow from './CategoryBudgetRow'
    import draggable from 'vuedraggable'

    export default {
        props: ['value', 'month'],
        components: {
            CategoryBudgetRow,
            draggable
        },
        computed: {
            categories: {
                get() {
                    return this.$store.getters.sortedCategories
                },
                set(value) {
                    this.$store.dispatch('sortCategories', value)
                }
            }
        },
        methods: {
            budgetForCategory(category) {
                let budget = this.value.find(x => category.id === x.id)
                if(budget) {
                    budget.month = this.month
                    return budget
                }
                return {
                    month: this.month,
                    budget: 0,
                    previousMonth: 0,
                    recommendedBudget: 0,
                    activity: 0
                }
            },
            updateBudget(value) {
                let result = this.value.filter(x => x.id !== value.id)
                result.push(value)

                this.$emit('input', result)
            }
        }
    }
</script>