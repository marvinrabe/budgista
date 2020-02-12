<script>
  import { Bar, mixins } from 'vue-chartjs'
  import { formatter } from '@/helpers'

  const { reactiveProp } = mixins

  export default {
    extends: Bar,
    mixins: [reactiveProp],
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
                return formatter.format(item.yLabel)
              }
            }
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
                callback: function (value) {
                  return formatter.format(value)
                }
              }
            }]
          }
        })
    }
  }
</script>
