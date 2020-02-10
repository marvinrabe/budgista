<template>
  <div class="overview">
    <AppNumber
      :label="$t('form.previousMonth')"
      :loading="loading"
      :value="previousMonth"
      class="d-none d-sm-flex"
    />
    <AppNumber
      :label="$t('form.income')"
      :loading="loading"
      :value="income"
      class="d-none d-sm-flex"
    />
    <AppNumber
      :color="true"
      :label="$t('form.unallocated')"
      :loading="loading"
      :value="unallocated"
    />
  </div>
</template>

<script>
  import AppNumber from '../AppNumber'

  export default {
    components: {
      AppNumber
    },
    props: {
      month: {
        type: Object,
        required: true
      },
      loading: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      budget () {
        return this.$store.getters['budgets/byMonth'](this.month)
      },
      previousMonth () {
        return this.budget ? this.budget.previousMonth : 0
      },
      income () {
        return this.budget ? this.budget.income : 0
      },
      budgeted () {
        return this.budget ? this.budget.rows
          .map(row => row.budget)
          .reduce((x, y) => x + y) : 0
      },
      unallocated () {
        return this.previousMonth + this.income - this.budgeted
      }
    }
  }
</script>

<style lang="scss" scoped>
  .overview {
    display: flex;
  }
</style>
