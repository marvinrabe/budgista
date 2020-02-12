<template>
  <div class="card">
    <div
      class="card-header"
      v-t="'title.statisticNetWorth'"
    />
    <div class="card-body">
      <div class="flex flex-column justify-content-center align-items-stretch text-muted">
        <AppSpinner v-if="loading"/>
        <LinearChart
          :chart-data="chartData"
          v-else
        />
      </div>
    </div>
  </div>
</template>

<script>
  import Month from '@/Utils/Month'
  import AppSpinner from '../AppSpinner'
  import LinearChart from './LinearChart'

  export default {
    components: {
      AppSpinner,
      LinearChart
    },
    props: {
      loading: {
        type: Boolean,
        default: false
      },
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
