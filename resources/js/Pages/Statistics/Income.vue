<template>
  <Layout :title="$t('title.statisticIncome')">
    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">{{ $t('title.statisticIncome')}}</h2>
      </div>
      <div class="flex justify-center p-4">
        <DonutChart :chart-data="chartData" class="w-full"/>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Pages/Statistics/Index'
  import DonutChart from '@/Components/statistics/DonutChart'
  import { green } from 'open-color'

  export default {
    components: {
      Layout,
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
            backgroundColor: ({dataIndex}) => {
              return green[6 - dataIndex % 5];
            },
            data: this.data.map(x => x.income)
          }]
        }
      }
    }
  }
</script>
