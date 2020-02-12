<template>
  <AppModal
    :title="$t('action.delete.group')"
    @close="$emit('close')"
  >
    <AppForm @submit="deleteGroup" ref="form">
      <i18n
        path="message.deleteGroup"
        tag="p"
      >
        <strong place="name">{{ group.name }}</strong>
      </i18n>

      <template slot="actions">
        <AppButton
          :label="$t('action.cancel')"
          @click="$emit('close')"
          subtle
        />

        <AppButton
          :label="$t('action.delete.group')"
          :loading="saving"
          @click="deleteGroup"
          variant="danger"
        />
      </template>
    </AppForm>
  </AppModal>
</template>

<script>
  import AppModal from '@/Components/AppModal'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'

  export default {
    components: {
      AppButton,
      AppForm,
      AppModal
    },
    props: {
      groupId: {
        type: String,
        required: true
      }
    },
    data () {
      return {
        saving: false
      }
    },
    methods: {
      deleteGroup () {
        this.saving = true

        /*this.$apollo
          .mutate({
            mutation: require('../../gql/mutation/groupDelete.gql'),
            variables: {
              id: this.groupId
            },
            refetchQueries: (mutationResult) => [{
              query: require('../../gql/query/groups.gql')
            }]
          })
          .then(() => {
            this.$emit('close')
          })
          .catch(this.$refs.form.error)
          .finally(() => {
            this.saving = false
          })*/
      }
    }
  }
</script>
