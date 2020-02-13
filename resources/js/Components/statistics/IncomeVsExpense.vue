<template>
  <div class="card">
    <div
      class="card-header"
      v-t="'title.statisticIncomeVsExpense'"
    />
    <div class="flex justify-center p-4">
      <LinearChart :chart-data="chartData" class="w-full"/>
    </div>
  </div>
</template>

<script>
  import LinearChart from './LinearChart'
  import Month from '@/Utils/Month'

  export default {
    components: {
      LinearChart
    },
    props: {
      statistics: {
        type: Array,
        required: true
      }
    },
    computed: {
      chartData () {
        return {
          labels: this.labels,
          datasets: this.datasets
        }
      },
      labels () {
        return this.statistics.map((x) => Month.fromString(x.month).format())
      },
      datasets () {
        return [
          {
            label: this.$t('form.income'),
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 173, 80, 0.5)',
            borderWidth: 1,
            data: this.statistics.map(x => x.income)
          },
          {
            label: this.$t('form.expense'),
            borderColor: '#F44336',
            backgroundColor: 'rgba(244, 67, 54, 0.5)',
            borderWidth: 1,
            data: this.statistics.map(x => x.expense)
          }
        ]
      }
    }
  }
</script>
