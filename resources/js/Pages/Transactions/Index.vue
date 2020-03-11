<template>
  <Layout :title="$t('title.transactions')">
    <div class="card ">
      <div class="card-header flex items-center border-b-0">
        <h2 class="text-xl">
          {{ $t('title.allTransactions') }}
        </h2>
        <div class="ml-auto text-right">
          <AppNumber
            :color="true"
            :label="$t('form.netWorth')"
            :value="netWorth"
          />
        </div>
      </div>
    </div>

    <TransactionList
      :transactions="transactions.data"
      with-state
    />

    <div class="flex items-center justify-end">
      <AppPagination :paginator="transactions"/>
    </div>
  </Layout>
</template>

<script>
  import { faPlus, faCog } from '@fortawesome/free-solid-svg-icons'
  import AppNumber from '@/Components/AppNumber'
  import AppButton from '@/Components/form/AppButton'
  import TransactionList from '@/Components/transactions/TransactionList'
  import { iconComponent } from '@/Utils/Icons'
  import AppPagination from '@/Components/AppPagination'
  import Layout from '@/Pages/Accounts/Index'

  export default {
    components: {
      Layout,
      AppNumber,
      AppPagination,
      TransactionList
    },
    props: {
      transactions: Object,
      netWorth: Number
    }
  }
</script>
