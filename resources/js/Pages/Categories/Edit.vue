<template>
  <Layout :title="$t('action.edit.category')">
    <template v-slot:actions>
      <AppButton
        :title="$t('action.delete.category')"
        @click="deleteCategory"
        subtle
        variant="danger"
      >
        <DeleteIcon/>
      </AppButton>
    </template>

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
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import FormGroup from '@/Components/form/FormGroup'
  import { iconComponent } from '@/helpers'
  import { faTrashAlt } from '@fortawesome/free-regular-svg-icons'
  import GroupSelect from '@/Components/groups/GroupSelect'

  export default {
    components: {
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
        this.$inertia.delete(this.category.links.destroy)
      }
    }
  }
</script>
