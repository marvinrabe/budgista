<template>
    <div class="budget-row" @click.stop="$refs.input.focus()">
        <div class="budget-column-name">
            <ellipsis>{{ category.name }}</ellipsis>
        </div>
        <div class="budget-column-values">
            <div class="budget-column-budget" @click.stop="">
                <money-input
                        class="py-0 px-1"
                        ref="input"
                        :class="[{ 'opacity-50': budget == 0 }]"
                        :value="budget"
                        @update:value="val => updateBudget(val)"
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
    </div>
</template>

<style>
    .budget-row {
        cursor: pointer;
    }
</style>

<script>
    export default {
        props: ['value', 'month'],
        data() {
            return {
                category_id: this.value.id,
                previousMonth: this.value.previousMonth,
                budget: this.value.budget,
                recommendedBudget: this.value.recommendedBudget,
                activity: this.value.activity
            }
        },
        computed: {
            category() {
                let category = this.$store.getters.findCategoryById(this.category_id)
                if (category === undefined) {
                    return {
                        name: ''
                    }
                }
                return category
            },
            available() {
                return this.previousMonth + this.budget + this.activity
            }
        },
        methods: {
            updateBudget: function (value) {
                axios
                    .put('/categories/' + this.category_id + '/budget', {
                        'month': this.month,
                        'amount': value
                    })
                    .then(response => {
                        this.budget = value
                        this.$emit('update:value', response.data)
                    })
                    .catch(e => {
                        console.error(e)
                    })

            }
        }
    }
</script>