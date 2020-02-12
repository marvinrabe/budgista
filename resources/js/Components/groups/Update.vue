<template>
  <AppModal
    :title="$t('action.edit.group')"
    @close="$emit('close')"
  >
    <GroupForm
      :value="group"
      @cancel="$emit('close')"
      @save="updateGroup"
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
      updateGroup (data) {
        /*this.$apollo
          .mutate({
            mutation: require('../../gql/mutation/groupUpdate.gql'),
            variables: {
              id: this.groupId,
              ...data
            },
            optimisticResponse: {
              __typename: 'Mutation',
              groupUpdate: {
                ...this.group,
                name: data.name
              }
            }
          })
          .catch(this.$refs.form.error)

        this.$emit('close')*/
      }
    }
  }
</script>
