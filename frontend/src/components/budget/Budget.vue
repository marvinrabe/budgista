<template>
    <div class="budget">
        <div class="budget-header">
            <div class="handle">&nbsp;</div>
            <div class="data">
                <div class="budget-column-name">
                    {{ $t('form.category') }}
                </div>
                <div class="budget-column-budget">
                    <span>{{ $t('form.budget') }}</span>
                </div>
                <div class="budget-column-activity">
                    <span>{{ $t('form.activity') }}</span>
                </div>
                <div class="budget-column-available">
                    <span>{{ $t('form.available') }}</span>
                </div>
            </div>
            <div class="actions">&nbsp;</div>
        </div>

        <draggable class="budget-groups"
                   :class="{'budget-groups--drag': drag}"
                   v-model="groups"
                   :options="{handle:'.budget-group-handle', group: 'groups'}"
                   @start="drag=true"
                   @end="drag=false">
            <budget-group
                    v-for="group in groups"
                    :loading="loading"
                    :key="group.id"
                    :group="group"
                    :month="month">
            </budget-group>
        </draggable>

        <budget-group
                v-if="hasUngroupedCategories"
                :loading="loading"
                :month="month">
        </budget-group>
    </div>
</template>

<style>
    .budget-groups--drag .budget-categories {
        display: none;
    }
</style>

<script>
    import draggable from 'vuedraggable'
    import BudgetGroup from './BudgetGroup'
    import {mapGetters} from 'vuex'

    export default {
        props: ['month', 'loading'],
        components: {
            BudgetGroup,
            draggable
        },
        data() {
            return {
                drag: false
            }
        },
        computed: {
            groups: {
                get() {
                    return this.$store.getters.sortedGroups
                },
                set(value) {
                    this.$store.dispatch('sortGroups', value)
                }
            },
            ...mapGetters([
                'hasUngroupedCategories'
            ])
        }
    }
</script>
