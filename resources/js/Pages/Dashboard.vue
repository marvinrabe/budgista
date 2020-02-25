<template>
  <div class="h-full flex items-center justify-center">
    <div class="flex flex-col">
      <AppNumber
        :label="$t('form.previousMonth')"
        class="mb-4"
        :value="$page.budget.previousMonth"
      />
      <AppNumber
        :label="$t('form.income')"
        class="mb-4"
        :value="$page.budget.income"
      />
      <AppNumber
        :label="$t('form.unallocated')"
        class="mb-4"
        :value="$page.budget.unallocated"
        color
      />
    </div>
  </div>
</template>

<script>
  import AppNumber from '@/Components/AppNumber'

  export default {
    components: {
      AppNumber
    }
  }
</script>
