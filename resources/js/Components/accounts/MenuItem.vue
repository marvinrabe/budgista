<template>
  <inertia-link
    :href="'/accounts/' + account.id"
    active-class="active"
    class="menu__item"
  >
    <font-awesome-icon
      :icon="icon"
      class="mr-1"
      fixed-width
    />
    <span class="ellipsis" style="flex: 1;">
      {{ account.name }}
    </span>
    <AppMoney
      :value="account.balance"
      class="ml-auto badge"
      color
    />
  </inertia-link>
</template>

<script>
  import { faCreditCard } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import AppMoney from '../AppMoney'
  import accountIcons from './accountIcons'

  export default {
    components: {
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
