<template>
  <Layout :title="$t('title.reset')">
    <div class="card">
      <div class="card-body">
        <h1
          class="card-title h4"
          v-t="'title.reset'"
        />

        <AppForm
          @submit="reset"
          ref="form"
        >
          <FormGroup name="email">
            <input
              class="form-input"
              data-vv-validate-on="input"
              slot-scope="{bindings}"
              type="email"
              v-bind="bindings"
              v-focus
              v-model="form.email"
              v-validate="'required|email'"
            >
          </FormGroup>

          <FormGroup name="password">
            <PasswordInput
              slot-scope="{bindings}"
              v-bind="bindings"
              v-model="form.password"
              validation="required|min:6"
            />
          </FormGroup>

          <template slot="actions">
            <AppButton
              :label="$t('action.reset')"
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
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import PasswordInput from '@/Components/form/PasswordInput'
  import FormGroup from '@/Components/form/FormGroup.vue'

  export default {
    components: {
      Layout,
      PasswordInput,
      AppButton,
      AppForm,
      FormGroup
    },
    props: {
      token: {
        type: String,
        required: true
      },
      email: {
        type: String,
        required: true
      }
    },
    data () {
      return {
        form: {
          email: this.email,
          password: '',
          token: this.token
        },
        loading: false
      }
    },
    methods: {
      reset () {
        this.loading = true

        this.$inertia
          .post('/password/reset', this.form)
          .finally(() => {
            this.loading = false
          })
      }
    }
  }
</script>
