<template>
  <Layout :title="$t('action.edit.transaction')">
    <div class="card">
      <AppForm @submit="saveTransaction" class="card-body">
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

      <AppButton
        type="button"
        class="hover:text-red-9"
        :label="$t('action.delete.transaction')"
        @click="deleteTransaction"
        subtle
      />
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
      saveTransaction () {
        this.saving = true

        this.$inertia
          .put(this.links.update, this.form)
          .finally(() => {
            this.saving = false
          })
      },
      deleteTransaction () {
        if (window.confirm(this.$t('message.deleteTransaction'))) {
          this.$inertia.delete(this.links.destroy)
        }
      }
    }
  }
</script>
