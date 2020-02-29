<template>
  <Layout :title="$t('title.statisticNetWorth')">
    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">{{ $t('title.statisticNetWorth')}}</h2>
      </div>
      <div class="flex justify-center p-4">
        <LinearChart :chart-data="chartData" class="w-full"/>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Pages/Statistics/Index'
  import LinearChart from '@/Components/statistics/LinearChart'
  import Month from '@/Utils/Month'

  export default {
    components: {
      Layout,
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
