<template>
  <Layout>
    <div class="card">
      <div class="card-header" v-t="'title.verify'"></div>

      <div class="card-body">
        {{ $t('message.verificationCheckEmail') }}
        {{ $t('message.verificationNotReceived') }}
        <a href="#"
           @click.prevent="resend"
           type="submit"
           class="btn btn-link p-0 m-0 align-baseline"
           v-t="'action.verificationResend'"></a>
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
    metaInfo () {
      return {
        title: this.$t('title.login')
      }
    },
    data () {
      return {
        loading: false
      }
    },
    methods: {
      resend () {
        this.loading = true

        this.$inertia
          .post('/email/resend', this.form)
          .finally(() => {
            this.loading = false
          })
      }
    }
  }
</script>
