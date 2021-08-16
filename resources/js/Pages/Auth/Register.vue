<template>
  <Layout :title="$t('title.register')">
    <div class="card">
      <div class="card-body p-6">
        <h1
          class="card-title text-center mb-6"
          v-t="'title.register'"
        />

        <p>Budgista will shut down on 31.12.2021. Registration not possible anymore.</p>
      </div>

      <div class="card-footer p-4 text-center">
        <span class="mr-1" v-t="'message.haveAccount'"/>
        <inertia-link
          href="/login"
          v-t="'action.login'"
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
  import FormGroup from '@/Components/form/FormGroup'
  import GoogleConnect from '@/Components/GoogleConnect'
  import _ from 'lodash'

  const termsUrl = 'TODO'

  export default {
    components: {
      Layout,
      PasswordInput,
      GoogleConnect,
      AppButton,
      AppForm,
      FormGroup
    },
    data () {
      return {
        form: {
          name: '',
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
