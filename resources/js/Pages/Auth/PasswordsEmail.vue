<template>
  <Layout :title="$t('title.reset')">
    <div class="card">
      <div class="card-body">
        <h1
          class="card-title h4"
          v-t="'title.reset'"
        />

        <AppForm
          @submit="sendReset"
          ref="form"
        >
          <FormGroup name="email">
            <input
              class="form-input"
              slot-scope="{bindings}"
              type="email"
              v-bind="bindings"
              v-model="form.email"
            >
          </FormGroup>

          <template slot="actions">
            <AppButton
              :label="$t('action.sendReset')"
              :loading="loading"
              variant="primary"
            />
          </template>
        </AppForm>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Auth'
  import FormGroup from '@/Components/form/FormGroup.vue'
  import AppForm from '@/Components/form/AppForm'
  import AppButton from '@/Components/form/AppButton'

  export default {
    components: {
      Layout,
      AppForm,
      AppButton,
      FormGroup
    },
    data () {
      return {
        form: {
          email: ''
        },
        loading: false
      }
    },
    methods: {
      sendReset () {
        this.loading = true

        this.$inertia
          .post('/password/email', this.form)
          .finally(() => {
            this.loading = false
          })
      }
    }
  }
</script>
