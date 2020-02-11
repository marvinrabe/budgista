<template>
  <b-dropdown-item
    v-t="'action.delete.account'"
    @click="showModal"
  >
    <AppModal
      v-if="visible"
      :title="$t('action.delete.account')"
      @close="hideModal"
    >
      <delete-account-form
        :account="account"
        @success="onSuccess"
        @cancel="hideModal"
      />
    </AppModal>
  </b-dropdown-item>
</template>

<script>
  import AppModal from '../AppModal'
  import DeleteAccountForm from './DeleteAccountForm'

  export default {
    components: {
      AppModal,
      DeleteAccountForm
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
      },
      onSuccess () {
        this.$router.push({ name: 'budget' })
        this.hideModal()
      }
    }
  }
</script>
