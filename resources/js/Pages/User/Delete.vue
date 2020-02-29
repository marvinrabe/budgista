<template>
  <Layout :title="$t('title.deleteUser')">
    <div class="card">
      <div class="card-body">
        <p class="mb-4" v-t="'message.deleteUser'"/>

        <AppForm @submit="deleteUser">
          <FormGroup name="feedback">
            <textarea
              class="form-control"
              slot-scope="{bindings}"
              v-bind="bindings"
              v-model="form.feedback"
            />
          </FormGroup>

          <FormGroup name="password">
            <PasswordInput
              :disable-strength="true"
              slot-scope="{bindings}"
              v-bind="bindings"
              v-model="form.password"
            />
          </FormGroup>

          <div slot="actions">
            <AppButton
              type="submit"
              :label="$t('action.deleteUser')"
              :loading="deleting"
              variant="danger"
            />
          </div>
        </AppForm>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import PasswordInput from '@/Components/form/PasswordInput'
  import FormGroup from '@/Components/form/FormGroup.vue'

  export default {
    components: {
      Layout,
      AppButton,
      AppForm,
      FormGroup,
      PasswordInput
    },
    data () {
      return {
        form: {
          feedback: '',
          password: '',
        },
        deleting: false
      }
    },
    methods: {
      deleteUser () {
        this.deleting = true

        this.$inertia
          .post('/profile/terminate', this.form)
          .finally(() => {
            this.deleting = false
          })
      }
    }
  }
</script>
