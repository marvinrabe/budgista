<template>
  <Layout :title="$t('action.create.category')">
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
  import GroupSelect from '@/Components/groups/GroupSelect'

  export default {
    components: {
      GroupSelect,
      Layout,
      AppButton,
      AppForm,
      FormGroup
    },
    props: {
      group: {
        type: Object,
        default: null
      }
    },
    data () {
      return {
        form: {
          name: '',
          group_id: this.group ? this.group.id : null
        },
        saving: false
      }
    },
    methods: {
      save () {
        this.saving = true

        this.$inertia
          .post('/categories', this.form)
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
