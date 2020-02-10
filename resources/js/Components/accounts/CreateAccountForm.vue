<template>
  <AppForm
    @submit="createAccount"
    ref="form"
  >
    <FormGroup name="name">
      <input
        class="form-control"
        slot-scope="{bindings}"
        type="text"
        v-bind="bindings"
        v-focus
        v-model="name"
        v-validate="'required'"
      >
    </FormGroup>

    <FormGroup name="initialBalance">
      <app-money-input
        slot-scope="{bindings}"
        v-bind="bindings"
        v-model="initialBalance"
        v-validate="'numeric'"
      />
    </FormGroup>

    <FormGroup name="icon">
      <account-icon-picker v-model="icon"/>
    </FormGroup>

    <div class="form-check">
      <input
        :value="true"
        class="form-check-input"
        id="tracking"
        type="checkbox"
        v-model="isTracking"
      >
      <label
        class="form-check-label"
        for="tracking"
        v-t="'form.trackingAccount'"
      />
    </div>

    <template slot="actions">
      <AppButton
        :label="$t('action.cancel')"
        @click="$emit('cancel')"
        subtle
      />

      <AppButton
        :label="$t('action.save')"
        :loading="saving"
        variant="primary"
      />
    </template>
  </AppForm>
</template>

<script>
  import AppButton from '../form/AppButton'
  import AppForm from '../form/AppForm'
  import FormGroup from '../form/FormGroup'
  import AppMoneyInput from '../form/AppMoneyInput'
  import AccountIconPicker from './AccountIconPicker'

  export default {
    components: {
      AppButton,
      AppForm,
      AccountIconPicker,
      AppMoneyInput,
      FormGroup
    },
    data () {
      return {
        saving: false,
        name: '',
        initialBalance: 0,
        icon: 'credit-card',
        isTracking: false
      }
    },
    methods: {
      createAccount () {
        this.saving = true

        this.$apollo
          .mutate({
            mutation: require('../../gql/mutation/accountCreate.gql'),
            variables: {
              initialBalance: this.initialBalance,
              input: {
                name: this.name,
                icon: this.icon,
                isTracking: this.isTracking
              }
            },
            update: (store, { data: { accountCreate } }) => {
              const query = require('../../gql/query/accounts.gql')
              const data = store.readQuery({ query: query })
              data.accounts.push(accountCreate)
              store.writeQuery({ query: query, data })
            }
          })
          .then(() => {
            this.$emit('success')
          })
          .catch(this.$refs.form.error)
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
