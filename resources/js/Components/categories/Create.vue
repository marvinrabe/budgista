<template>
  <AppModal
    :title="$t('action.create.category')"
    @close="$emit('close')"
  >
    <CategoryForm
      @cancel="$emit('close')"
      @save="createCategory"
      ref="form"
    />
  </AppModal>
</template>

<script>
  import AppModal from '@/Components/AppModal'
  import CategoryForm from '@/Components/categories/CategoryForm'

  export default {
    components: {
      AppModal,
      CategoryForm
    },
    props: {
      groupId: {
        type: String,
        default: null
      }
    },
    data () {
      return {
        saving: false
      }
    },
    methods: {
      createCategory (data) {
        this.saving = true

        /*this.$apollo
          .mutate({
            mutation: require('../../gql/mutation/categoryCreate.gql'),
            variables: {
              ...data,
              groupId: this.groupId
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
