<template>
  <Layout>
    <div class="card">
      <div class="card-body">
        <h1
          class="card-title h4 mb-3"
          v-t="'title.register'"
        />

        <AppForm
          @submit="register"
          ref="form"
        >
          <FormGroup name="email">
            <input
              class="form-control"
              data-vv-validate-on="input"
              slot-scope="{bindings}"
              type="email"
              v-bind="bindings"
              v-model="form.email"
            >
          </FormGroup>

          <FormGroup name="password">
            <PasswordInput
              slot-scope="{bindings}"
              v-bind="bindings"
              v-model="form.password"
            />
          </FormGroup>

          <FormGroup
            :has-label="false"
            name="terms"
          >
            <div
              class="form-check"
              slot-scope="{bindings, id}"
            >
              <input
                class="form-check-input"
                type="checkbox"
                v-bind="bindings"
                v-model="form.terms"
              >
              <i18n
                :for="id"
                class="form-check-label"
                path="form.termsOfService"
                tag="label"
              >
                <a
                  :href="termsUrl"
                  target="_blank"
                >{{ $t('word.termsOfService') }}</a>
              </i18n>
            </div>
          </FormGroup>

          <template slot="actions">
            <AppButton
              :label="$t('action.register')"
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
  import FormGroup from '@/Components/form/FormGroup'

  const termsUrl = 'TODO'

  export default {
    components: {
      Layout,
      PasswordInput,
      AppButton,
      AppForm,
      FormGroup
    },
    metaInfo () {
      return {
        title: this.$t('title.register')
      }
    },
    data () {
      return {
        form: {
          email: '',
          password: '',
          terms: false
        },
        termsUrl: termsUrl,
        loading: false
      }
    },
    methods: {
      register () {
        this.loading = true

        this.$inertia
          .post('/register', this.form)
          .finally(() => {
            this.loading = false
          })
      }
    }
  }
</script>
