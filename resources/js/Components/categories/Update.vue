<template>
  <AppModal
    :title="$t('action.edit.category')"
    @close="$emit('close')"
  >
    <CategoryForm
      :value="category"
      @cancel="$emit('close')"
      @save="updateCategory"
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
      categoryId: {
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
      updateCategory (data) {
        /*this.$apollo
          .mutate({
            mutation: require('../../gql/mutation/categoryUpdate.gql'),
            variables: {
              id: this.categoryId,
              ...data
            },
            optimisticResponse: {
              __typename: 'Mutation',
              categoryUpdate: {
                ...this.category,
                name: data.name
              }
            }
          })
          .catch(this.$refs.form.error)*/

        this.$emit('close')
      }
    }
  }
</script>
