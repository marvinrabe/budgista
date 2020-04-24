<template>
  <div>
    <h3
      class="text-lg mb-4"
      v-t="'title.updatePassword'"
    />

    <AppForm @submit="save" v-if="$page.user.has_password">
      <FormGroup
        label="oldPassword"
        name="password"
      >
        <PasswordInput
          :disable-strength="true"
          v-model="form.password"
        />
      </FormGroup>

      <FormGroup name="newPassword">
        <PasswordInput
          slot-scope="{bindings}"
          v-bind="bindings"
          v-model="form.new_password"
          validation="required|min:6"
        />
      </FormGroup>

      <div slot="actions">
        <AppButton
          :label="$t('action.settings.password')"
          :loading="saving"
          variant="primary"
        />
      </div>
    </AppForm>
    <div v-else>
      <p class="text-gray-6 mb-4">
        {{ $t('message.newPassword')}}
      </p>

      <p class="text-red-9 mb-4" v-if="$page.errors['email']">
        {{ $page.errors['email'][0]}}
      </p>

      <AppButton
        :label="$t('action.newPassword')"
        @click="newPassword"
        :loading="saving"
        variant="primary"
        class="ml-auto"
      />
    </div>
  </div>
</template>

<script>
  import PasswordInput from '@/Components/form/PasswordInput'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import FormGroup from '@/Components/form/FormGroup'

  export default {
    components: {
      AppForm,
      AppButton,
      PasswordInput,
      FormGroup
    },
    data () {
      return {
        form: {
          password: '',
          new_password: ''
        },
        saving: false
      }
    },
    methods: {
      reset () {
        this.form = {
          password: '',
          new_password: ''
        }
      },
      save () {
        this.saving = true

        this.$inertia
          .post('/settings/security/password', this.form)
          .then(() => {
            this.reset()
          })
          .finally(() => {
            this.saving = false
          })
      },
      newPassword () {
        this.$inertia
          .post('/password/email', {
            email: this.$page.user.email
          })
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
