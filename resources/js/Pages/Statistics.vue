<template>
  <Layout>
    <AppToolbar :title="$t('title.statistics')"/>

    <NetWorth :statistics="data" class="mb-3"/>

    <IncomeVsExpense :statistics="data"/>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppToolbar from '@/Components/AppToolbar'
  import IncomeVsExpense from '@/Components/statistics/IncomeVsExpense'
  import NetWorth from '@/Components/statistics/NetWorth'

  export default {
    components: {
      Layout,
      AppToolbar,
      NetWorth,
      IncomeVsExpense
    },
    metaInfo () {
      return {
        title: this.$t('title.statistics')
      }
    },
    props: {
      data: Array
    }
  }
</script>
