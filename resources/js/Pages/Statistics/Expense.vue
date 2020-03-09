<template>
  <Layout :title="$t('title.statisticExpense')">
    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">{{ $t('title.statisticExpense')}}</h2>
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
  import {red} from 'open-color/open-color'

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
              return red[6 - dataIndex % 5];
            },
            data: this.data.map(x => x.expense)
          }]
        }
      }
    }
  }
</script>
