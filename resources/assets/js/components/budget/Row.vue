<template>
    <div class="budget-row">
        <div class="budget-column-drag">
            <span class="handle"></span>
        </div>
        <div class="budget-column-name">
            {{ category.name }}
        </div>
        <div class="budget-column-budget">
            <money-input
                    class="text-right py-0 px-1"
                    ref="input"
                    :class="[{ 'text-muted': budget == 0 }, { 'text-dark': budget != 0 }]"
                    :value="budget"
                    @update:value="val => updateBudget(val)"
                    v-b-tooltip.left
                    :title="$t('form.recommendedBudget')+': '+$moneyFormatter().format(recommendedBudget)">
            </money-input>
        </div>
        <div class="budget-column-activity d-none d-lg-block">
            <money-format
                    :class="[{ 'text-muted': activity == 0 }, { 'text-dark': activity != 0 }]"
                    :value="activity">
            </money-format>
        </div>
        <div class="budget-column-available">
            <money-format
                    style="font-size: 100%"
                    class="badge"
                    :class="[{ 'badge-danger': available < 0 }, { 'badge-success': available > 0 }, { 'badge-light': available == 0 }]"
                    :value="available">
            </money-format>
        </div>
        <div class="budget-column-actions">
            <slot name="actions"></slot>
        </div>
    </div>
</template>


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
            };
        },
        computed: {
            category() {
                let category = this.$store.getters.findCategoryById(this.category_id);
                if(_.isEmpty(category)) { // TODO remove when category row list is managed by vuex
                    return {
                        name: ''
                    };
                }
                return category;
            },
            available() {
                return this.previousMonth + this.budget + this.activity;
            }
        },
        methods: {
            updateBudget: function (value) {
                axios
                    .put('/api/categories/' + this.category_id + '/budget', {
                        'month': this.month,
                        'amount': value
                    })
                    .then(response => {
                        this.budget = value;
                        this.$emit('update:value', response.data);
                    })
                    .catch(e => {
                        console.error(e);
                    });

            }
        }
    }
</script>