<template>
  <AppModal
    :title="$t('action.delete.category')"
    @close="$emit('close')"
  >
    <AppForm
      @submit="deleteCategory"
      ref="form"
    >
      <FormGroup name="transferTransactions">
        <category-select
          :exclude="categoryId"
          slot-scope="{bindings}"
          v-bind="bindings"
          v-model="newCategory"
        />
      </FormGroup>

      <i18n
        path="message.deleteCategory"
        tag="p"
      >
        <strong place="name">{{ category.name }}</strong>
      </i18n>

      <template slot="actions">
        <AppButton
          :label="$t('action.cancel')"
          @click="$emit('close')"
          subtle
        />

        <AppButton
          :label="$t('action.delete.category')"
          :loading="saving"
          @click="deleteCategory"
          variant="danger"
        />
      </template>
    </AppForm>
  </AppModal>
</template>

<script>
  import AppForm from '@/Components/form/AppForm'
  import AppModal from '@/Components/AppModal'
  import CategorySelect from '@/Components/categories/CategorySelect'
  import AppButton from '@/Components/form/AppButton'
  import FormGroup from '@/Components/form/FormGroup.vue'

  export default {
    components: {
      AppButton,
      AppForm,
      AppModal,
      CategorySelect,
      FormGroup
    },
    props: {
      categoryId: {
        type: String,
        required: true
      }
    },
    data () {
      return {
        saving: false,
        newCategory: null
      }
    },
    methods: {
      deleteCategory () {
        this.saving = true

        /*this.$apollo
          .mutate({
            mutation: require('../../gql/mutation/categoryDelete.gql'),
            variables: {
              id: this.categoryId,
              transferToCategoryId: this.newCategory
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
