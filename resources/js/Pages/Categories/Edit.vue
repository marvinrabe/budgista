<template>
  <Layout :title="$t('action.edit.category')">
    <div class="card">
      <div class="card-header">
        {{ $t('action.edit.category') }}
      </div>
      <div class="card-body">
        <AppForm @submit="save">
          <FormGroup name="name">
            <input
              class="form-control"
              slot-scope="{bindings}"
              type="text"
              v-bind="bindings"
              v-model="form.name"
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
      <div class="card-body border-t border-gray-3">
        <form @submit.prevent="deleteCategory" class="flex -mx-1 flex-wrap items-end justify-between">
          <div class="flex-1 px-1">
            <h2 class="text-xl mb-2">
              {{ $t('action.delete.category') }}
            </h2>
            <p class="mb-4">{{ $t('hint.deleteCategory') }}</p>
            <FormGroup name="category_id" label="transferTransactions" class="mb-0">
              <CategorySelect
                :exclude="category.id"
                slot-scope="{bindings}"
                v-bind="bindings"
                v-model="deleteForm.category_id"
              />
            </FormGroup>
          </div>
          <div class="lg:ml-4 mt-4 w-full lg:w-auto flex justify-end">
            <AppButton
              type="submit"
              :label="$t('action.delete.category')"
              :loading="saving"
              variant="danger"
            />
          </div>
        </form>
      </div>
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
          name: this.category.name
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
