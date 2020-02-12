<template>
  <AppForm
    @submit="save"
    ref="form"
  >
    <div class="form-row align-items-baseline">
      <div class="col-lg-4">
        <h2
          class="h5"
          v-t="'title.updatePassword'"
        />
      </div>
      <div class="col-lg-4">
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
      <div class="col-lg-4">
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
  import axios from 'axios'
  import AppButton from '../form/AppButton'
  import AppForm from '../form/AppForm'
  import FormGroup from '../form/FormGroup'

  export default {
    components: {
      AppForm,
      AppButton,
      PasswordInput,
      FormGroup
    },
    data () {
      return {
        saving: false,
        form: {
          password: '',
          new_password: ''
        }
      }
    },
    mounted () {
      this.reset()
    },
    methods: {
      reset () {
        this.saving = false
        this.form.password = ''
        this.form.new_password = ''
      },
      save () {
        this.saving = true

        axios.post('/user/password', this.form)
          .then(() => {
            this.$snotify.success(this.$t('message.updatePassword'))
          })
          .catch(this.$refs.form.error)
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
