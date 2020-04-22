<template>
  <div>
    <h3 class="text-lg mb-2">{{ $t('title.statisticIncomeVsExpense')}}</h3>
    <div class="card p-8">
      <LinearChart :chart-data="chartData" class="w-full"/>
    </div>
  </div>
</template>

<script>
  import LinearChart from '@/Components/statistics/LinearChart'
  import Month from '@/Utils/Month'
  import { red, green } from 'open-color/open-color'

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
            borderColor: green[7],
            backgroundColor: green[6] + 'C0', // 75% Opacity
            hoverBackgroundColor: green[6],
            borderWidth: 1,
            data: this.data.map(x => x.income)
          },
          {
            label: this.$t('form.expense'),
            borderColor: red[7],
            backgroundColor: red[6] + 'C0', // 75% Opacity
            hoverBackgroundColor: red[6],
            borderWidth: 1,
            data: this.data.map(x => x.expense)
          }
        ]
      }
    }
  }
</script>
