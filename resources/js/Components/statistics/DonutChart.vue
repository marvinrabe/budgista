<script>
  import { Doughnut, mixins } from 'vue-chartjs'
  import { mixin as moneyMixin } from '@/Utils/Money'

  const { reactiveProp } = mixins

  export default {
    extends: Doughnut,
    mixins: [reactiveProp, moneyMixin],
    mounted () {
      const self = this

      this.renderChart(
        this.chartData,
        {
          defaultFontFamily: '\'Inter\', sans-serif',
          responsive: true,
          maintainAspectRatio: false,
          animation: false,
          legend: false,
          tooltips: {
            callbacks: {
              label: function (item, { datasets, labels }) {
                let label = labels[item.index]
                if (label == null) {
                  label = self.$t('form.uncategorized')
                }

                let value = self.moneyFormat.format(datasets[item.datasetIndex].data[item.index])

                return `${label}: ${value}`
              }
            }
          }
        }
      )
    }
  }
</script>
