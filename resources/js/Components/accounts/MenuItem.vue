<template>
  <AppMenuItem
    :href="account.links.show"
    :icon="icon"
    :label="account.name"
  >
    <AppMoney
      :value="account.balance"
      class="ml-auto text-xs"
      color
    />
  </AppMenuItem>
</template>

<script>
  import { faCreditCard } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import AppMoney from '../AppMoney'
  import accountIcons from './accountIcons'
  import AppMenuItem from '@/Components/AppMenuItem'

  export default {
    components: {
      AppMenuItem,
      AppMoney,
      FontAwesomeIcon
    },
    props: {
      account: {
        type: Object,
        required: true
      }
    },
    computed: {
      icon () {
        let icon = accountIcons.find(x => x.name === this.account.icon)
        if (icon) {
          return icon.icon
        }
        return faCreditCard
      }
    }
  }
</script>
