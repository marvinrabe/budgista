<template>
  <div>
    <h3 class="text-lg mb-4">{{ $t('title.statisticNetWorth')}}</h3>
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
            label: this.$t('title.statisticNetWorth'),
            borderColor: 'rgba(33, 150, 243, 0.3)',
            pointBackgroundColor: '#2196F3',
            backgroundColor: 'transparent',
            type: 'line',
            data: this.data.map(x => x.worth)
          }
        ]
      }
    }
  }
</script>
