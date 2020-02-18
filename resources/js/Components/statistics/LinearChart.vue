<script>
  import { Bar, mixins } from 'vue-chartjs'
  import { mixin as moneyMixin } from '@/Utils/Money'

  const { reactiveProp } = mixins

  export default {
    extends: Bar,
    mixins: [reactiveProp, moneyMixin],
    mounted () {
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
                return this.moneyFormat.format(item.yLabel)
              }
            }
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
                callback: function (value) {
                  return this.moneyFormat.format(value)
                }
              }
            }]
          }
        })
    }
  }
</script>
