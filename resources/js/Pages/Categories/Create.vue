<template>
  <Layout :title="$t('action.create.category')">
    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">
          {{ $t('action.create.category') }}
        </h2>
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
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Pages/Settings/Index'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import FormGroup from '@/Components/form/FormGroup'

  export default {
    components: {
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
          name: ''
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
