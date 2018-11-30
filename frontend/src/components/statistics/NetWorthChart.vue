<script>
    import {Bar} from 'vue-chartjs'

    export default {
        props: ['labels', 'datasets'],
        extends: Bar,
        mounted() {
            let self = this

            this.renderChart({
                labels: this.labels,
                datasets: this.datasets
            }, {
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
