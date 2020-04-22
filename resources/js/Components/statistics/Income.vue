<template>
  <div>
    <h3 class="text-lg mb-2">{{ $t('title.statisticIncome')}}</h3>
    <div class="card p-8 relative">
      <div class="absolute-center flex flex-col justify-center items-center">
        <div class="label">{{ $t('word.total') }}</div>
        <AppMoney class="text-lg md:text-xl font-light" :value="total"/>
      </div>
      <DonutChart :chart-data="chartData" class="w-full"/>
    </div>
  </div>
</template>

<script>
  import DonutChart from '@/Components/statistics/DonutChart'
  import { green, red } from 'open-color'
  import AppMoney from '@/Components/AppMoney'

  export default {
    components: {
      AppMoney,
      DonutChart
    },
    props: {
      data: Array
    },
    computed: {
      total () {
        return this.data.reduce((acc, x) => acc + x.income, 0)
      },
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
