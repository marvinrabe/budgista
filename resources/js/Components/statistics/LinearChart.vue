<script>
  import { Bar, mixins } from 'vue-chartjs'
  import moneyFormat from '../../mixins/moneyFormat'

  const { reactiveProp } = mixins

  export default {
    extends: Bar,
    mixins: [reactiveProp, moneyFormat],
    mounted () {
      let self = this

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
                return self.moneyFormat(item.yLabel)
              }
            }
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
                callback: function (value) {
                  return self.moneyFormat(value)
                }
              }
            }]
          }
        })
    }
  }
</script>
