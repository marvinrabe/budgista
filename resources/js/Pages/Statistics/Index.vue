<template>
  <Layout :title="$t('title.statistics')" redirect="/statistics/netWorth">
    <template v-slot:menu>
      <h2 class="text-xl mb-4 px-4">
        {{ $t('title.statistics') }}
      </h2>

      <AppMenu>
        <AppMenuItem
          :label="$t('title.statisticNetWorth')"
          :icon="icons.netWorth"
          href="/statistics/netWorth"/>
        <AppMenuItem
          :label="$t('title.statisticIncomeVsExpense')"
          :icon="icons.incomeVsExpense"
          href="/statistics/incomeVsExpense"/>
        <AppMenuItem
          :label="$t('title.statisticExpense')"
          :icon="icons.pieChart"
          href="/statistics/expense"/>
        <AppMenuItem
          :label="$t('title.statisticIncome')"
          :icon="icons.pieChart"
          href="/statistics/incomes"/>
      </AppMenu>
    </template>

    <slot/>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Container'
  import AppMenu from '@/Components/AppMenu'
  import AppMenuItem from '@/Components/AppMenuItem'
  import { faChartLine, faChartBar, faChartPie } from '@fortawesome/free-solid-svg-icons'

  export default {
    components: {
      AppMenu,
      AppMenuItem,
      Layout,
    },
    props: {
      title: {
        type: String,
        default: null
      }
    },
    data() {
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
