<template>
    <div class="card mb-3">
        <div class="budget-group">
            <div class="handle budget-group-handle">
                <span class="small text-dark"
                      v-if="group">
                    <font-awesome-icon icon="arrows-alt-v" fixed-width/>
                </span>
            </div>
            <div class="data">
                <div class="budget-column-name" v-if="group">
                    <font-awesome-icon :icon="collapsedIcon" @click.prevent="collapse" fixed-width/>
                    <a href="#" @click.prevent="collapse" class="text-dark">
                        {{ group.name }}
                    </a>
                </div>
                <div class="budget-column-name" v-else>
                    {{ $t('title.ungrouped') }}
                </div>
                <div class="budget-column-budget">
                    <app-skeleton :busy="loading" variant="dark-light">
                        <money-format :value="budget"></money-format>
                    </app-skeleton>
                </div>
                <div class="budget-column-activity">
                    <app-skeleton :busy="loading" variant="dark-light">
                        <money-format :value="activity"></money-format>
                    </app-skeleton>
                </div>
                <div class="budget-column-available">
                    <app-skeleton :busy="loading" variant="dark-light">
                        <money-format :value="available"></money-format>
                    </app-skeleton>
                </div>
            </div>
            <div class="actions">
                <group-settings :group="group" v-if="group"></group-settings>
            </div>
        </div>

        <draggable class="budget-categories"
                   v-model="categories"
                   v-if="categoriesVisible"
                   :options="{handle:'.budget-row-handle', group: 'categories'}">
            <budget-category
                    v-for="category in categories"
                    :key="category.id"
                    :loading="loading"
                    :category="category"
                    :budget="budgetForCategory(category)"
                    @update:budget="updateBudget">
            </budget-category>
        </draggable>
    </div>
</template>

<script>
    import BudgetCategory from './BudgetCategory'
    import GroupSettings from '../groups/GroupSettings'
    import draggable from 'vuedraggable'
    import collect from 'collect.js'
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
    import {faChevronDown, faChevronRight} from '@fortawesome/free-solid-svg-icons'
    import AppSkeleton from '../AppSkeleton'

    export default {
        props: ['group', 'value', 'month', 'loading'],
        components: {
            BudgetCategory,
            GroupSettings,
            draggable,
            FontAwesomeIcon,
            AppSkeleton
        },
        computed: {
            categoriesVisible() {
                return !this.group || !this.group.collapsed
            },
            collapsedIcon() {
                return this.categoriesVisible ? faChevronDown : faChevronRight
            },
            sheet() {
                let categories = this.categories.map(x => x.id)
                return collect(this.value).filter(x => categories.includes(x.id))
            },
            groupId() {
                return this.group ? this.group.id : null
            },
            categories: {
                get() {
                    return this.$store.getters.sortedCategoriesByGroup(this.groupId)
                },
                set(value) {
                    this.$store.dispatch('sortCategories', {
                        group_id: this.groupId,
                        categories: value
                    })
                }
            },
            budget() {
                return this.sheet.sum('budget')
            },
            activity() {
                return this.sheet.sum('activity')
            },
            available() {
                return this.sheet.sum('available')
            }
        },
        methods: {
            budgetForCategory(category) {
                let budget = this.value.find(x => category.id === x.id)
                if (budget) {
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
            },
            collapse() {
                this.$store
                    .dispatch('toggleGroupCollapsed', {
                        id: this.groupId,
                        collapsed: this.categoriesVisible
                    })
            }
        }
    }
</script>
