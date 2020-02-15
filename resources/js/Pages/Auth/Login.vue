<template>
  <Layout :title="$t('title.login')">
    <div class="card">
      <div class="card-body">
        <h1
          class="card-title h4"
          v-t="'title.login'"
        />

        <AppForm
          @submit="login"
          ref="form"
        >
          <FormGroup name="email">
            <input
              class="form-control"
              data-vv-validate-on="input"
              slot-scope="{bindings}"
              tabindex="1"
              type="email"
              v-bind="bindings"
              v-model="form.email"
            >
          </FormGroup>

          <FormGroup name="password">
            <template slot-scope="{bindings}">
              <div class="float-right">
                <inertia-link
                  href="/password/reset"
                  class="text-muted small"
                  v-t="'message.forgotPassword'"
                />
              </div>
              <PasswordInput
                :disable-strength="true"
                tabindex="2"
                v-bind="bindings"
                v-model="form.password"
              />
            </template>
          </FormGroup>

          <template slot="actions">
            <div class="form-group mr-auto">
              <div class="form-check">
                <input
                  class="form-check-input"
                  id="remember"
                  tabindex="3"
                  type="checkbox"
                  v-model="form.remember"
                >
                <label
                  class="form-check-label"
                  for="remember"
                  v-t="'form.remember'"
                />
              </div>
            </div>

            <AppButton
              :label="$t('action.login')"
              :loading="loading"
              tabindex="4"
              variant="primary"
            />
          </template>
        </AppForm>
      </div>

      <div class="card-footer text-center">
        <span class="mr-1" v-t="'message.noAccount'"/>
        <inertia-link
          href="/register"
          v-t="'message.noAccountSignUp'"
        />
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
    data () {
      return {
        form: {
          email: '',
          password: '',
          remember: false
        },
        loading: false
      }
    },
    methods: {
      login () {
        this.loading = true

        this.$inertia
          .post('/login', this.form)
          .finally(() => {
            this.loading = false
          })
      }
    }
  }
</script>
