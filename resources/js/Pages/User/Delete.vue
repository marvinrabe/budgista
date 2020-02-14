<template>
  <Layout>
    <AppToolbar :title="$t('title.deleteUser')"/>

    <div class="card mb-3">
      <div class="card-body">
        <p v-t="'message.deleteUser'"/>

        <AppForm@submit="deleteUser">
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
              :label="$t('action.deleteUser')"
              :loading="deleting"
              @click="deleteUser"
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
  import AppToolbar from '@/Components/AppToolbar'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import PasswordInput from '@/Components/form/PasswordInput'
  import FormGroup from '@/Components/form/FormGroup.vue'

  export default {
    components: {
      Layout,
      AppButton,
      AppForm,
      AppToolbar,
      FormGroup,
      PasswordInput
    },
    metaInfo () {
      return {
        title: this.$t('title.deleteUser')
      }
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

        this.$inertia.post('/profile', this.form)
      }
    }
  }
</script>
