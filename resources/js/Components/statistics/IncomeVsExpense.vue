<template>
  <div class="card">
    <div
      class="card-header"
      v-t="'title.statisticIncomeVsExpense'"
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
  import AppSpinner from '../AppSpinner'
  import LinearChart from './LinearChart'
  import Month from '@/Utils/Month'

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
            label: this.$t('form.income'),
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 173, 80, 0.5)',
            borderWidth: 1,
            data: this.statistics.map(x => x.income)
          },
          {
            label: this.$t('form.expense'),
            borderColor: '#F44336',
            backgroundColor: 'rgba(244, 67, 54, 0.5)',
            borderWidth: 1,
            data: this.statistics.map(x => x.expense)
          }
        ]
      }
    }
  }
</script>
