<template>
  <div class="balance">
    <AppNumber
      :color="true"
      :label="$t('form.balance.cleared')"
      :loading="loading"
      :value="account.balanceCleared"
    />
    <AppNumber
      :color="true"
      :label="$t('form.balance.working')"
      :loading="loading"
      :value="account.balance"
    />
  </div>
</template>

<style scoped>
  .balance {
    padding: 0 1em;
    margin: 0 -.5em;
    display: flex;
  }
</style>

<script>
  import AppNumber from '../AppNumber'

  export default {
    components: {
      AppNumber
    },
    props: {
      account: {
        type: Object,
        default: () => {
          return {
            balance: 0,
            balanceCleared: 0
          }
        }
      },
      loading: {
        type: Boolean,
        default: false
      }
    }
  }
</script>
