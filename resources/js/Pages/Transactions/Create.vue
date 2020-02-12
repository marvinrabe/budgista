<template>
  <Layout>
    <AppToolbar :title="$t('action.create.transaction')"/>

    <div class="card">
      <div class="card-body">
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
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppToolbar from '@/Components/AppToolbar'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import TransactionForm from '@/Components/transactions/TransactionForm'

  export default {
    components: {
      Layout,
      AppButton,
      AppForm,
      AppToolbar,
      TransactionForm
    },
    props: {
      account: {
        type: Object,
        required: false,
        default: null
      }
    },
    metaInfo () {
      return {
        title: this.$t('action.create.transaction')
      }
    },
    data () {
      return {
        form: {
          account_id: this.account ? this.account.id : null
        },
        saving: false
      }
    },
    methods: {
      save () {
        this.saving = true

        this.$inertia
          .post('/transactions', this.form)
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
