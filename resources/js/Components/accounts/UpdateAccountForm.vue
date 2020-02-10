<template>
  <AppForm
    @submit="updateAccount"
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
        variant="primary"
      />
    </template>
  </AppForm>
</template>

<script>
  import AppButton from '../form/AppButton'
  import AppForm from '../form/AppForm'
  import AccountIconPicker from './AccountIconPicker'
  import FormGroup from '../form/FormGroup'

  export default {
    components: {
      AccountIconPicker,
      AppButton,
      AppForm,
      FormGroup
    },
    props: {
      account: {
        type: Object,
        required: true
      }
    },
    data () {
      return {
        name: this.account.name,
        icon: this.account.icon,
        isTracking: this.account.isTracking
      }
    },
    methods: {
      updateAccount () {
        this.$emit('success')

        this.$apollo
          .mutate({
            mutation: require('../../gql/mutation/accountUpdate.gql'),
            variables: {
              id: this.account.id,
              input: {
                name: this.name,
                icon: this.icon,
                isTracking: this.isTracking
              }
            },
            optimisticResponse: {
              __typename: 'Mutation',
              accountUpdate: {
                ...this.account,
                name: this.name,
                icon: this.icon,
                isTracking: this.isTracking
              }
            }
          })
          .catch(this.$refs.form.error)
      }
    }
  }
</script>
