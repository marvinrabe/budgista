<script>
  import { Doughnut, mixins } from 'vue-chartjs'
  import { mixin as moneyMixin } from '@/Utils/Money'
  import { gray } from 'open-color/open-color'

  const { reactiveProp } = mixins

  export default {
    extends: Doughnut,
    mixins: [reactiveProp, moneyMixin],
    mounted () {
      const self = this

      const data = this.hasData
        ? this.chartData
        : {datasets: [{
            backgroundColor: '#fff',
            hoverBackgroundColor: '#fff',
            borderColor: gray[3],
            hoverBorderColor: gray[3],
            borderWidth: 1,
            hoverBorderWidth: 1,
            data: [1]
          }]
        }

        this.renderChart(
          data,
          {
            defaultFontFamily: '\'Inter\', sans-serif',
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            legend: false,
            tooltips: this.hasData ? {
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
            } : false
          }
        )
    },
    computed: {
      hasData() {
        return this.chartData.datasets[0].data.length;
      }
    }
  }
</script>
