<template>
  <AppForm
    @submit="save"
    ref="form"
  >
    <div class="-mx-1 flex flex-wrap items-baseline">
      <div class="px-1 w-full lg:w-4/12">
        <h2
          class="text-xl mb-2"
          v-t="'title.updatePassword'"
        />
      </div>
      <div class="px-1 w-full lg:w-4/12">
        <FormGroup
          label="oldPassword"
          name="password"
        >
          <PasswordInput
            :disable-strength="true"
            v-model="form.password"
          />
        </FormGroup>
      </div>
      <div class="px-1 w-full lg:w-4/12">
        <FormGroup name="newPassword">
          <PasswordInput
            slot-scope="{bindings}"
            v-bind="bindings"
            v-model="form.new_password"
            validation="required|min:6"
          />
        </FormGroup>
      </div>
    </div>

    <div slot="actions">
      <AppButton
        :label="$t('action.settings.password')"
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
          .post('/profile/password', this.form)
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
