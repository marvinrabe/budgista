<template>
  <AppForm @submit="save" ref="form">
    <div class="form-row align-items-baseline">
      <div class="col-lg-4">
        <h2
          class="h5"
          v-t="'title.updateEmail'"
        />
      </div>
      <div class="col-lg-8">
        <FormGroup name="currentEmail">
          <div class="form-text" v-if="me">
            {{ me.email }}
            <span
              class="badge badge-success"
              v-if="me.isVerified"
              v-t="'word.verified'"
            />
            <span
              class="badge badge-warning"
              v-else
              v-t="'word.unverified'"
            />
            <resend-verification
              class="btn-sm"
              v-if="!me.isVerified"
            />
          </div>
          <div class="form-text">
            <AppSkeleton/>
          </div>
        </FormGroup>

        <FormGroup name="newEmail">
          <input
            class="form-control"
            slot-scope="{bindings}"
            type="email"
            v-bind="bindings"
            v-model="form.email"
            v-validate="'required|email'"
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
  import PasswordInput from '@/components/form/PasswordInput'
  import axios from 'axios'
  import AppSkeleton from '../AppSkeleton'
  import AppButton from '../form/AppButton'
  import AppForm from '../form/AppForm'
  import ResendVerification from '../profile/ResendVerification'
  import FormGroup from '../form/FormGroup'

  export default {
    components: {
      AppSkeleton,
      PasswordInput,
      ResendVerification,
      AppForm,
      AppButton,
      FormGroup
    },
    data () {
      return {
        saving: false,
        form: {
          email: '',
          password: ''
        }
      }
    },
    apollo: {
      me: {
        query: require('../../gql/query/me.gql')
      }
    },
    computed: {
      email () {
        return this.$store.state.user.email
      }
    },
    methods: {
      save () {
        this.saving = true
        axios
          .post('/user/email', this.form)
          .then(() => {
            this.$apollo.queries.me.refetch()
            this.$snotify.success(this.$t('message.updateEmail'))
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
