<template>
  <div>
    <h3 class="text-lg mb-4">{{ $t('title.statisticNetWorth')}}</h3>
    <LinearChart :chart-data="chartData" class="w-full"/>
  </div>
</template>

<script>
  import LinearChart from '@/Components/statistics/LinearChart'
  import Month from '@/Utils/Month'
  import { blue } from 'open-color/open-color'

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
            borderColor: blue[1],
            pointBackgroundColor: blue[6],
            backgroundColor: 'transparent',
            type: 'line',
            data: this.data.map(x => x.worth)
          }
        ]
      }
    }
  }
</script>
