<script>
    import {Bar, mixins} from 'vue-chartjs'

    const {reactiveProp} = mixins

    export default {
        mixins: [reactiveProp],
        extends: Bar,
        mounted() {
            let self = this

            this.renderChart(
                this.chartData,
                {
                    defaultFontFamily: 'Roboto, sans-serif',
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom'
                    },
                    tooltips: {
                        callbacks: {
                            label: function (item) {
                                return self.$moneyFormatter().format(item.yLabel)
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function (value) {
                                    return self.$moneyFormatter().format(value)
                                }
                            }
                        }]
                    }
                })
        }
    }
</script>
