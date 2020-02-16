<template>
  <AppForm @submit="save" ref="form">
    <div class="flex -mx-1 flex-wrap items-baseline">
      <div class="px-1 w-full lg:w-4/12">
        <h2
          class="text-xl"
          v-t="'title.updateEmail'"
        />
      </div>
      <div class="px-1 w-full lg:w-8/12">
        <FormGroup name="currentEmail">
          <div class="form-text">
            {{ $page.user.email }}
            <span
              class="bg-green-0 rounded p-1 text-xs"
              v-if="$page.user.email_verified_at"
              v-t="'word.verified'"
            />
            <span
              class="bg-yellow-0 rounded p-1 text-xs"
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
      save () {
        this.saving = true

        this.$inertia
          .post('/profile/email', this.form)
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
