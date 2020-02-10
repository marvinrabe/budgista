<template>
  <b-dropdown-item
    v-t="'action.edit.account'"
    @click="showModal"
  >
    <AppModal
      v-if="visible"
      :title="$t('action.edit.account')"
      @close="hideModal"
    >
      <update-account-form
        :account="account"
        @success="hideModal"
        @cancel="hideModal"
      />
    </AppModal>
  </b-dropdown-item>
</template>

<script>
  import AppModal from '../AppModal'
  import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'
  import UpdateAccountForm from './UpdateAccountForm'

  export default {
    components: {
      AppModal,
      bDropdownItem,
      UpdateAccountForm
    },
    props: ['account'],
    data () {
      return {
        visible: false
      }
    },
    methods: {
      showModal () {
        this.visible = true
      },
      hideModal () {
        this.visible = false
      }
    }
  }
</script>
