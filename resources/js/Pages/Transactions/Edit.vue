<template>
  <Layout :title="$t('action.edit.transaction')">
    <template v-slot:actions>
      <AppButton
        :title="$t('action.delete.transaction')"
        @click="deleteTransaction"
        subtle
        variant="danger"
        icon
      >
        <DeleteIcon/>
      </AppButton>
    </template>

    <h2 class="text-xl mb-4 px-4">
      {{ $t('action.edit.transaction') }}
    </h2>

    <div class="card" v-if="transaction">
      <div class="card-body">
        <AppForm @submit="saveTransaction">
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
  import TransactionForm from '@/Components/transactions/TransactionForm'
  import { faTrashAlt } from '@fortawesome/free-regular-svg-icons'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import { iconComponent } from '@/Utils/Icons'

  export default {
    components: {
      AppButton,
      AppForm,
      Layout,
      DeleteIcon: iconComponent({ icon: faTrashAlt }),
      TransactionForm
    },
    props: {
      transaction: Object
    },
    data () {
      return {
        form: this.transaction,
        saving: false
      }
    },
    methods: {
      saveTransaction () {
        this.saving = true

        this.$inertia
          .put(this.transaction.links.update, this.form)
          .finally(() => {
            this.saving = false
          })
      },
      deleteTransaction () {
        if (window.confirm(this.$t('message.deleteTransaction'))) {
          this.$inertia.delete(this.transaction.links.destroy)
        }
      }
    }
  }
</script>
