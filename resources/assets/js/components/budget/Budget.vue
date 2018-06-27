<template>
    <div class="budget" v-else>
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

        <draggable class="budget-groups"
                   :class="{'budget-groups--drag': drag}"
                   v-model="groups"
                   :options="{handle:'.budget-group-handle', group: 'groups'}"
                   @start="drag=true"
                   @end="drag=false">
            <budget-group
                    v-for="group in groups"
                    :value="value"
                    @input="value => $emit('input', value)"
                    :key="group.id"
                    :group="group"
                    :month="month">
            </budget-group>
        </draggable>

        <budget-group
                v-if="hasUngroupedCategories"
                :value="value"
                @input="value => $emit('input', value)"
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
    import { mapGetters } from 'vuex'

    export default {
        props: ['value', 'month'],
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