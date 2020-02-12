<template>
  <div class="main">
    <AppToolbar :title="$t('title.deleteUser')"/>

    <div class="card mb-3">
      <div class="card-body">
        <p v-t="'message.deleteUser'"/>

        <AppForm
          @submit="deleteUser"
          ref="form"
        >
          <FormGroup name="feedback">
            <textarea
              class="form-control"
              slot-scope="{bindings}"
              v-bind="bindings"
              v-model="feedback"
            />
          </FormGroup>

          <FormGroup name="password">
            <PasswordInput
              :disable-strength="true"
              slot-scope="{bindings}"
              v-bind="bindings"
              v-model="password"
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
  </div>
</template>

<script>
  import axios from 'axios'
  import AppToolbar from '@/Components/AppToolbar'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import PasswordInput from '@/Components/form/PasswordInput'
  import FormGroup from '@/Components/form/FormGroup.vue'

  export default {
    components: {
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
        feedback: '',
        password: '',
        deleting: false
      }
    },
    methods: {
      deleteUser () {
        this.deleting = true

        axios
          .delete('/user', {
            data: {
              password: this.password,
              feedback: this.feedback
            }
          })
          .then(() => {
            this.$snotify.success(this.$t('message.userDeleted'))
            this.$auth.logout({
              makeRequest: true,
              success: function () {
                this.$store.dispatch('RESET')
              },
              redirect: { name: 'login' }
            })
          })
          .catch(this.$refs.form.error)
          .finally(() => {
            this.deleting = false
          })
      }
    }
  }
</script>
