<template>
  <Layout :title="$t('title.transactions')">
    <template v-slot:header>
      <h2 class="text-xl">
        {{ $t('title.allTransactions') }}
      </h2>
      <div class="ml-auto text-right">
        <MoneyColumn
          :color="true"
          :label="$t('form.netWorth')"
          :value="netWorth"
        />
      </div>
    </template>

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
  import MoneyColumn from '@/Components/MoneyColumn'
  import TransactionList from '@/Components/transactions/TransactionList'
  import AppPagination from '@/Components/AppPagination'
  import Layout from '@/Layouts/Default'

  export default {
    components: {
      Layout,
      MoneyColumn,
      AppPagination,
      TransactionList
    },
    props: {
      transactions: Object,
      netWorth: Number
    }
  }
</script>
