<template>
  <Layout :title="$t('action.edit.category')">
    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">
          {{ $t('action.edit.category') }}
        </h2>
      </div>
      <div class="card-body">
        <AppForm @submit="save">
          <FormGroup name="name">
            <input
              class="form-input"
              slot-scope="{bindings}"
              type="text"
              v-bind="bindings"
              v-model="form.name"
            >
          </FormGroup>

          <FormGroup name="description" optional>
            <input
              class="form-input"
              slot-scope="{bindings}"
              type="text"
              v-bind="bindings"
              v-model="form.description"
            >
          </FormGroup>

          <template slot="actions">
            <AppButton
              :label="$t('action.save')"
              :loading="saving"
              variant="primary"
            />
          </template>
        </AppForm>
      </div>

      <form @submit.prevent="deleteCategory" class="card-body border-t border-gray-3">
        <h3 class="text-lg mb-2">
          {{ $t('action.delete.category') }}
        </h3>
        <p class="mb-4">{{ $t('hint.deleteCategory') }}</p>

        <div class="flex flex-col lg:flex-row items-end">
          <FormGroup name="category_id" label="transferTransactions" class="w-full flex-1 mb-0">
            <CategorySelect
              :exclude="category.id"
              slot-scope="{bindings}"
              v-bind="bindings"
              v-model="deleteForm.category_id"
            />
          </FormGroup>

          <div class="lg:ml-2 mt-2">
            <AppButton
              type="submit"
              :label="$t('action.delete.category')"
              :loading="saving"
              variant="danger"
            />
          </div>
        </div>
      </form>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Pages/Settings/Index'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import FormGroup from '@/Components/form/FormGroup'
  import { iconComponent } from '@/Utils/Icons'
  import { faTrashAlt } from '@fortawesome/free-regular-svg-icons'
  import CategorySelect from '@/Components/categories/CategorySelect'

  export default {
    components: {
      CategorySelect,
      Layout,
      AppButton,
      AppForm,
      FormGroup,
      DeleteIcon: iconComponent({ icon: faTrashAlt }),
    },
    props: {
      category: Object
    },
    data () {
      return {
        form: {
          name: this.category.name,
          description: this.category.description
        },
        deleteForm: {
          category_id: null
        },
        saving: false
      }
    },
    methods: {
      save () {
        this.saving = true

        this.$inertia
          .put(this.category.links.update, this.form)
          .finally(() => {
            this.saving = false
          })
      },
      deleteCategory () {
        if (window.confirm(this.$t('message.deleteCategory', { name: this.category.name }))) {
          this.saving = true

          this.$inertia
            .post(this.category.links.destroy, this.deleteForm)
            .finally(() => {
              this.saving = false
            })
        }
      }
    }
  }
</script>
