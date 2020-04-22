<template>
  <div>
    <h3 class="text-lg mb-2">{{ $t('title.statisticIncome')}}</h3>
    <div class="card p-8">
      <DonutChart :chart-data="chartData" class="w-full"/>
    </div>
  </div>
</template>

<script>
  import DonutChart from '@/Components/statistics/DonutChart'
  import { green, red } from 'open-color'

  export default {
    components: {
      DonutChart
    },
    props: {
      data: Array
    },
    computed: {
      chartData () {
        return {
          labels: this.data.map((x) => x.category),
          datasets: [{
            backgroundColor: ({ dataIndex }) => {
              return green[6 - dataIndex % 5] + 'C0' // 75% Opacity
            },
            hoverBackgroundColor: ({ dataIndex }) => {
              return green[6]
            },
            data: this.data.map(x => x.income)
          }]
        }
      }
    }
  }
</script>
