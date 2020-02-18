<script>
  import { Bar, mixins } from 'vue-chartjs'
  import { mixin as moneyMixin } from '@/Utils/Money'

  const { reactiveProp } = mixins

  export default {
    extends: Bar,
    mixins: [reactiveProp, moneyMixin],
    mounted () {
      const self = this;

      this.renderChart(
        this.chartData,
        {
          defaultFontFamily: '\'Inter\', sans-serif',
          responsive: true,
          maintainAspectRatio: false,
          animation: false,
          legend: {
            position: 'bottom'
          },
          tooltips: {
            callbacks: {
              label: function (item) {
                return self.moneyFormat.format(item.yLabel)
              }
            }
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
                callback: function (value) {
                  return self.moneyFormat.format(value)
                }
              }
            }]
          }
        })
    }
  }
</script>
