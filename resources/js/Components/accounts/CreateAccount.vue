<template>
  <AppButton
    :title="$t('action.create.account')"
    @click="showModal"
    class="ml-auto"
    small
    subtle
  >
    <PlusIcon/>
    <AppModal
      :title="$t('action.create.account')"
      @close="hideModal"
      v-if="visible"
    >
      <create-account-form
        @cancel="hideModal"
        @success="hideModal"
      />
    </AppModal>
  </AppButton>
</template>

<script>
  import { faPlus } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import AppButton from '../form/AppButton'
  import AppModal from '../AppModal'
  import CreateAccountForm from './CreateAccountForm'
  import { prepareComponent } from '../../helpers'

  const PlusIcon = prepareComponent(FontAwesomeIcon, { icon: faPlus })

  export default {
    components: {
      AppModal,
      AppButton,
      CreateAccountForm,
      PlusIcon
    },
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
