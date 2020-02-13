<template>
  <div class="card">
    <div
      class="card-header"
      v-t="'title.statisticNetWorth'"
    />
    <div class="flex justify-center p-4">
      <LinearChart :chart-data="chartData" class="w-full"/>
    </div>
  </div>
</template>

<script>
  import Month from '@/Utils/Month'
  import LinearChart from './LinearChart'

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
            label: this.$t('title.statisticNetWorth'),
            borderColor: 'rgba(33, 150, 243, 0.3)',
            pointBackgroundColor: '#2196F3',
            backgroundColor: 'transparent',
            type: 'line',
            data: this.statistics.map(x => x.worth)
          }
        ]
      }
    }
  }
</script>
