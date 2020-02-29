<template>
  <Layout :title="$t('action.create.transaction')">
    <h2 class="text-xl mb-4 px-4">
      {{ $t('action.create.transaction') }}
    </h2>

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
      account: {
        type: Object,
        required: false,
        default: null
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
