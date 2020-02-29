<template>
  <Layout :title="$t('title.statisticIncomeVsExpense')">
    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">{{ $t('title.statisticIncomeVsExpense')}}</h2>
      </div>
      <div class="flex justify-center p-4">
        <LinearChart :chart-data="chartData" class="w-full"/>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Pages/Statistics/Index'
  import LinearChart from '@/Components/statistics/LinearChart'
  import Month from '@/Utils/Month'

  export default {
    components: {
      Layout,
      LinearChart
    },
    props: {
      data: Array
    },
    computed: {
      chartData () {
        return {
          labels: this.labels,
          datasets: this.datasets
        }
      },
      labels () {
        return this.data.map((x) => Month.fromString(x.month).format())
      },
      datasets () {
        return [
          {
            label: this.$t('form.income'),
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 173, 80, 0.5)',
            borderWidth: 1,
            data: this.data.map(x => x.income)
          },
          {
            label: this.$t('form.expense'),
            borderColor: '#F44336',
            backgroundColor: 'rgba(244, 67, 54, 0.5)',
            borderWidth: 1,
            data: this.data.map(x => x.expense)
          }
        ]
      }
    }
  }
</script>
