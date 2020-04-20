<template>
  <AppForm @submit="save" ref="form">
    <h3
      class="text-xl mb-4"
      v-t="'title.updateEmail'"
    />

    <FormGroup name="currentEmail">
      <div class="form-text">
        {{ $page.user.email }}
        <span
          class="badge badge--green text-xs"
          v-if="$page.user.email_verified_at"
          v-t="'word.verified'"
        />
        <span
          class="badge badge--yellow text-xs"
          v-else
          v-t="'word.unverified'"
        />
        <resend-verification
          class="inline-block"
          v-if="!$page.user.email_verified_at"
        />
      </div>
    </FormGroup>

    <FormGroup name="newEmail">
      <input
        class="form-input"
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
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import ResendVerification from '@/Components/profile/ResendVerification'
  import FormGroup from '@/Components/form/FormGroup'

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
      reset () {
        this.form = {
          email: '',
          password: ''
        }
      },
      save () {
        this.saving = true

        this.$inertia
          .post('/profile/email', this.form)
          .then(() => {
            this.reset()
          })
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
