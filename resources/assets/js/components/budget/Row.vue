<template>
    <div class="budget-row">
        <div class="budget-column-drag">
            <span class="handle"></span>
        </div>
        <div class="budget-column-name">
            <a class="link-action text-dark"
               :title="$t('action.edit.category')"
               @click="showEditCategoryModal">
                {{ name }}
            </a>
        </div>
        <div class="budget-column-budget">
            <money-input
                    class="text-right py-0 px-1"
                    ref="input"
                    :class="[{ 'text-muted': budget == 0 }, { 'text-dark': budget != 0 }]"
                    :value="budget"
                    @update:value="val => updateBudget(val)"
                    v-b-tooltip.left
                    :title="$t('form.recommendedBudget')+': '+$formatMoney(recommendedBudget)">
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
    </div>
</template>


<script>
    export default {
        props: ['value', 'month'],
        data() {
            return {
                id: this.value.id,
                name: this.value.name,
                previousMonth: this.value.previousMonth,
                budget: this.value.budget,
                recommendedBudget: this.value.recommendedBudget,
                activity: this.value.activity
            };
        },
        computed: {
            available() {
                return this.previousMonth + this.budget + this.activity;
            }
        },
        methods: {
            updateBudget: function (value) {
                axios
                    .put('/api/categories/' + this.id + '/budget', {
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

            },
            showEditCategoryModal: function() {
                // TODO: how?
            }
        }
    }
</script>