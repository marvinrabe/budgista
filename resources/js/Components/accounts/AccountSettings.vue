<template>
  <b-dropdown
    no-caret
    right
    variant="light"
  >
    <template slot="button-content">
      <font-awesome-icon :icon="icon" />
    </template>
    <update-account :account="account" />
    <delete-account :account="account" />
  </b-dropdown>
</template>

<script>
  import { faEllipsisH } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
  import DeleteAccount from './DeleteAccount'
  import UpdateAccount from './UpdateAccount'

  export default {
    components: {
      bDropdown,
      FontAwesomeIcon,
      DeleteAccount,
      UpdateAccount
    },
    props: ['account'],
    computed: {
      icon () {
        return faEllipsisH
      }
    }
  }
</script>
