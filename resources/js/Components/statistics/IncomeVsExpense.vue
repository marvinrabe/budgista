<template>
  <div>
    <h3 class="text-lg mb-4">{{ $t('title.statisticIncomeVsExpense')}}</h3>
    <LinearChart :chart-data="chartData" class="w-full"/>
  </div>
</template>

<script>
  import LinearChart from '@/Components/statistics/LinearChart'
  import Month from '@/Utils/Month'

  export default {
    components: {
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
            backgroundColor: '#48BB78',
            borderWidth: 0,
            data: this.data.map(x => x.income)
          },
          {
            label: this.$t('form.expense'),
            backgroundColor: '#F56565',
            borderWidth: 0,
            data: this.data.map(x => x.expense)
          }
        ]
      }
    }
  }
</script>
