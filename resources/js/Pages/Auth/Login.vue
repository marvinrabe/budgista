<template>
  <Layout :title="$t('title.login')">
    <div class="card">
      <div class="card-body p-6">
        <h1
          class="card-title text-center mb-6"
          v-t="'title.login'"
        />

        <FormGroup name="google" :has-label="false">
          <GoogleConnect
            :label="$t('action.googleLogin')"
            class="block w-full"
          />
        </FormGroup>

        <hr class="hr-text" :data-content="$t('word.or')">

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
              <PasswordInput
                :disable-strength="true"
                tabindex="2"
                v-bind="bindings"
                v-model="form.password"
              />
            </template>
          </FormGroup>

          <template slot="actions">
            <div class="mb-4 mr-auto">
              <inertia-link
                href="/password/reset"
                class="text-sm ml-auto text-gray-6 hover:text-gray-8"
                v-t="'message.forgotPassword'"
              />
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

      <div class="card-footer p-4 text-center">
        <span class="mr-1" v-t="'message.noAccount'"/>
        <inertia-link
          href="/register"
          v-t="'action.register'"
        />
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Auth'
  import GoogleConnect from '@/Components/GoogleConnect'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import PasswordInput from '@/Components/form/PasswordInput'
  import FormGroup from '@/Components/form/FormGroup.vue'

  export default {
    components: {
      Layout,
      GoogleConnect,
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
