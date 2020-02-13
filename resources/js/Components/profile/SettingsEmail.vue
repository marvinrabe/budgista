<template>
  <AppForm @submit="save" ref="form">
    <div class="flex -mx-1 flex-wrap items-baseline">
      <div class="px-1 w-full lg:w-4/12">
        <h2
          class="h5"
          v-t="'title.updateEmail'"
        />
      </div>
      <div class="px-1 w-full lg:w-8/12">
        <FormGroup name="currentEmail">
          <div class="form-text">
            {{ $page.user.email }}
            <span
              class="badge badge-success"
              v-if="$page.user.email_verified_at"
              v-t="'word.verified'"
            />
            <span
              class="badge badge-warning"
              v-else
              v-t="'word.unverified'"
            />
            <resend-verification
              class="btn-sm"
              v-if="!$page.user.email_verified_at"
            />
          </div>
        </FormGroup>

        <FormGroup name="newEmail">
          <input
            class="form-control"
            slot-scope="{bindings}"
            type="email"
            v-bind="bindings"
            v-model="form.email"
          >
        </FormGroup>

        <FormGroup name="password">
          <PasswordInput
            :disable-strength="true"
            slot-scope="{bindings}"
            v-bind="bindings"
            v-model="form.password"
          />
        </FormGroup>
      </div>
    </div>

    <div slot="actions">
      <AppButton
        :label="$t('action.settings.email')"
        :loading="saving"
        variant="primary"
      />
    </div>
  </AppForm>
</template>

<script>
  import PasswordInput from '@/Components/form/PasswordInput'
  import axios from 'axios'
  import AppButton from '../form/AppButton'
  import AppForm from '../form/AppForm'
  import ResendVerification from '../profile/ResendVerification'
  import FormGroup from '../form/FormGroup'

  export default {
    components: {
      PasswordInput,
      ResendVerification,
      AppForm,
      AppButton,
      FormGroup
    },
    data () {
      return {
        form: {
          email: '',
          password: ''
        },
        saving: false
      }
    },
    methods: {
      save () {
        this.saving = true

        axios
          .post('/user/email', this.form)
          .then(() => {
            this.form.email = ''
            this.form.password = ''
            this.$validator.reset()
          })
          .catch(this.$refs.form.error)
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
