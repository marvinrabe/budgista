<template>
  <AppModal
    :title="$t('action.create.group')"
    @close="$emit('close')"
  >
    <GroupForm
      @cancel="$emit('close')"
      @save="createGroup"
      ref="form"
    />
  </AppModal>
</template>

<script>
  import AppModal from '@/Components/AppModal'
  import GroupForm from '@/Components/groups/GroupForm'

  export default {
    components: {
      AppModal,
      GroupForm
    },
    data () {
      return {
        saving: false
      }
    },
    methods: {
      createGroup (data) {
        this.saving = true

        /*this.$apollo
          .mutate({
            mutation: require('../../gql/mutation/groupCreate.gql'),
            variables: data,
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
