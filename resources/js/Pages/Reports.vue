<template>
  <Layout :title="$t('title.reports')" redirect="/statistics/netWorth">
    <NetWorth v-bind="netWorth"/>
    <IncomeVsExpense v-bind="incomeVsExpense"/>
    <div class="-mx-2 flex flex-wrap">
      <div class="w-full lg:w-1/2 px-2">
        <Income v-bind="income"/>
      </div>
      <div class="w-full lg:w-1/2 px-2">
        <Expense v-bind="expense"/>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import { faChartLine, faChartBar, faChartPie } from '@fortawesome/free-solid-svg-icons'
  import NetWorth from '@/Components/statistics/NetWorth'
  import IncomeVsExpense from '@/Components/statistics/IncomeVsExpense'
  import Income from '@/Components/statistics/Income'
  import Expense from '@/Components/statistics/Expense'

  export default {
    components: {
      Expense,
      Income,
      IncomeVsExpense,
      NetWorth,
      Layout,
    },
    props: {
      netWorth: Object,
      incomeVsExpense: Object,
      income: Object,
      expense: Object
    },
    data () {
      return {
        icons: {
          netWorth: faChartLine,
          incomeVsExpense: faChartBar,
          pieChart: faChartPie
        }
      }
    },
  }
</script>
