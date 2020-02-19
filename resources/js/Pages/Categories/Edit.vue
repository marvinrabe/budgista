<template>
  <Layout :title="$t('action.edit.category')">
    <div class="card">
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

          <FormGroup name="group_id">
            <GroupSelect
              slot-scope="{bindings}"
              v-bind="bindings"
              v-model="form.group_id"
            />
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
    </div>

    <div class="card">
      <div class="card-header">
        {{ $t('action.delete.category') }}
      </div>
      <div class="card-body">
        <AppForm @submit="deleteCategory">
          <FormGroup name="category_id" label="transferTransactions">
            <CategorySelect
              :exclude="category.id"
              slot-scope="{bindings}"
              v-bind="bindings"
              v-model="deleteForm.category_id"
            />
          </FormGroup>

          <template slot="actions">
            <AppButton
              type="submit"
              :label="$t('action.delete.category')"
              :loading="saving"
              variant="danger"
            />
          </template>
        </AppForm>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import FormGroup from '@/Components/form/FormGroup'
  import { iconComponent } from '@/Utils/Icons'
  import { faTrashAlt } from '@fortawesome/free-regular-svg-icons'
  import GroupSelect from '@/Components/groups/GroupSelect'
  import CategorySelect from '@/Components/categories/CategorySelect'

  export default {
    components: {
      CategorySelect,
      GroupSelect,
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
          group_id: this.category.group_id
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
