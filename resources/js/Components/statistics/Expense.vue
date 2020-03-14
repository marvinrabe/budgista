<template>
  <div>
    <h3 class="text-lg mb4">{{ $t('title.statisticExpense')}}</h3>
    <DonutChart :chart-data="chartData" class="w-full"/>
  </div>
</template>

<script>
  import DonutChart from '@/Components/statistics/DonutChart'
  import { red } from 'open-color/open-color'

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
              return red[6 - dataIndex % 5]
            },
            data: this.data.map(x => x.expense)
          }]
        }
      }
    }
  }
</script>
