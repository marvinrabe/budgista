<template>
  <Layout :title="$t('action.edit.group')">
    <template v-slot:actions>
      <AppButton
        :title="$t('action.delete.group')"
        @click="deleteGroup"
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

  export default {
    components: {
      Layout,
      AppButton,
      AppForm,
      FormGroup,
      DeleteIcon: iconComponent({ icon: faTrashAlt }),
    },
    props: {
      group: Object
    },
    data () {
      return {
        form: {
          name: this.group.name
        },
        saving: false
      }
    },
    methods: {
      save () {
        this.saving = true;

        this.$inertia
          .put(this.group.links.update, this.form)
          .finally(() => {
            this.saving = false
          })
      },
      deleteGroup() {
        this.$inertia.delete(this.group.links.destroy)
      }
    }
  }
</script>
