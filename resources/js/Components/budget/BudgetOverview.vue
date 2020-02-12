<template>
  <div class="flex">
    <AppNumber
      :label="$t('form.previousMonth')"
      :value="budget.previousMonth"
      class="d-none sm:flex"
    />
    <AppNumber
      :label="$t('form.income')"
      :value="budget.income"
      class="d-none sm:flex"
    />
    <AppNumber
      :label="$t('form.unallocated')"
      :value="budget.unallocated"
      color
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
      budget: Object
    }
  }
</script>
