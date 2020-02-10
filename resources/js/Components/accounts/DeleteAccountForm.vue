<template>
  <AppForm
    @submit="deleteAccount"
    ref="form"
  >
    <i18n
      path="message.deleteAccount"
      tag="p"
    >
      <strong place="name">{{ account.name }}</strong>
    </i18n>

    <template slot="actions">
      <AppButton
        :label="$t('action.cancel')"
        @click="$emit('cancel')"
        subtle
      />

      <AppButton
        :label="$t('action.delete.account')"
        :loading="saving"
        @click="deleteAccount"
        variant="danger"
      />
    </template>
  </AppForm>
</template>

<script>
  import AppButton from '../form/AppButton'
  import AppForm from '../form/AppForm'

  export default {
    props: {
      account: {
        type: Object,
        required: true
      }
    },
    components: {
      AppButton,
      AppForm
    },
    data () {
      return {
        saving: false
      }
    },
    methods: {
      deleteAccount () {
        this.saving = true

        this.$apollo
          .mutate({
            mutation: require('../../gql/mutation/accountDelete.gql'),
            variables: {
              id: this.account.id
            },
            update: (store, { data: { accountDelete } }) => {
              const query = require('../../gql/query/accounts.gql')

              const accounts = store.readQuery({ query }).accounts.filter(account => account.id !== accountDelete.id)

              store.writeQuery({ query, data: { accounts } })
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
