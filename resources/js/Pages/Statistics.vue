<template>
  <Layout :title="$t('title.statistics')">
    <NetWorth :statistics="data" class="mb-3"/>

    <IncomeVsExpense :statistics="data"/>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import IncomeVsExpense from '@/Components/statistics/IncomeVsExpense'
  import NetWorth from '@/Components/statistics/NetWorth'

  export default {
    components: {
      Layout,
      NetWorth,
      IncomeVsExpense
    },
    props: {
      data: Array
    }
  }
</script>
