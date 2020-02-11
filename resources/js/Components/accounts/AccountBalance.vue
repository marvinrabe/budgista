<template>
  <div class="flex px-4 -mx-2">
    <AppNumber
      :color="true"
      :label="$t('form.balance.cleared')"
      :value="account.balance_cleared"
    />
    <AppNumber
      :color="true"
      :label="$t('form.balance.working')"
      :value="account.balance"
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
      account: Object
    }
  }
</script>
