<template>
    <div class="budget-row">
        <div class="handle budget-row-handle">
            <span class="small text-dark">
                <font-awesome-icon icon="arrows-alt-v" fixed-width/>
            </span>
        </div>
        <div class="data"
             @click.stop="$refs.input.focus()">
            <div class="budget-column-name">
                <ellipsis>{{ category.name }}</ellipsis>
            </div>
            <div class="budget-column-budget" @click.stop="">
                <money-input
                        class="py-0 px-1"
                        ref="input"
                        :class="[{ 'opacity-50': budgeted == 0 }]"
                        :value="budgeted"
                        @input="val => updateBudget(val)"
                        :title="$t('form.recommendedBudget')+': '+$moneyFormatter().format(recommendedBudget)"></money-input>
            </div>
            <div class="budget-column-activity">
                <money-format
                        :class="[{ 'opacity-50': activity == 0 }, { 'opacity-80': activity != 0 }]"
                        :value="activity"></money-format>
            </div>
            <div class="budget-column-available">
                <money-format
                        :class="[{ 'text-danger': available < 0 }, { 'text-success': available > 0 }, { 'opacity-50': available == 0 }]"
                        :value="available"></money-format>
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

    export default {
        props: ['category', 'budget'],
        components: {
            CategorySettings
        },
        data() {
            return {
                previousMonth: this.budget.previousMonth,
                budgeted: this.budget.budget,
                recommendedBudget: this.budget.recommendedBudget,
                activity: this.budget.activity
            }
        },
        computed: {
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