<template>
  <Layout :title="$t('action.create.transaction')">
    <AppForm @submit="save">
      <TransactionForm v-model="form"/>

      <template slot="actions">
        <AppButton
          :label="$t('action.save')"
          :loading="saving"
          variant="primary"
        />
      </template>
    </AppForm>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import TransactionForm from '@/Components/transactions/TransactionForm'

  export default {
    components: {
      Layout,
      AppButton,
      AppForm,
      TransactionForm
    },
    props: {
      referer: {
        type: String,
        default: null
      },
      transaction: Object,
      links: Object
    },
    data () {
      return {
        form: this.transaction,
        saving: false
      }
    },
    methods: {
      save () {
        this.saving = true

        this.$inertia
          .post(this.links.store, {
            ...this.form,
            referer: this.referer
          })
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
