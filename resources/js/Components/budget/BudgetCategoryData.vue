<template>
  <div
    @click.stop="$refs.input.focus()"
    class="data"
  >
    <div class="budget-column-name ellipsis">
      {{ category.name }}
    </div>
    <div
      @click.stop
      class="budget-column-budget"
    >
      <AppMoneyInput
        :title="recommendedTitle"
        :value="row.budget"
        @change="val => updateBudget(val)"
        ref="input"
      />
    </div>
    <div class="budget-column-activity">
      <AppMoney :value="row.activity"/>
    </div>
    <div class="budget-column-available">
      <AppMoney
        :value="row.available"
        color
      />
    </div>
  </div>
</template>

<script>
  import moneyFormat from '../../mixins/moneyFormat'
  import AppMoney from '../AppMoney'
  import AppMoneyInput from '../form/AppMoneyInput'

  export default {
    mixins: [moneyFormat],
    components: {
      AppMoney,
      AppMoneyInput
    },
    props: {
      category: {
        type: Object,
        required: true
      },
      month: {
        type: Object,
        required: true
      }
    },
    computed: {
      row () {
        return this.$store.getters['budgets/getRow'](this.month, this.category.id)
      },
      recommendedTitle () {
        return this.$t('form.recommendedBudget') + ': ' + this.moneyFormat(this.row.recommendedBudget)
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

<style lang="scss" scoped>
  .data {
    cursor: pointer;
  }
</style>
