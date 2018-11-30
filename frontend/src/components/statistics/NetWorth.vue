<template>
    <div class="card">
        <div class="card-header" v-t="'title.statisticNetWorth'"></div>
        <div class="card-body">
            <div class="flex flex-column justify-content-center align-items-stretch">
                <AppSpinner v-if="loading"/>
                <NetWorthChart v-else :chart-data="chartData" />
            </div>
        </div>
    </div>
</template>

<script>
    import collect from 'collect.js'
    import AppSpinner from '../AppSpinner'
    import NetWorthChart from './NetWorthChart'

    export default {
        components: {
            AppSpinner,
            NetWorthChart
        },
        data() {
            return {
                loading: true
            }
        },
        computed: {
            chartData() {
                return {
                    labels: this.labels,
                    datasets: this.datasets
                }
            },
            labels() {
                return this.$store.getters['statistics/labels']
            },
            rawData() {
                return this.$store.state.statistics.statistics
            },
            datasets() {
                return [
                    {
                        label: this.$t('form.income'),
                        borderColor: '#4CAF50',
                        backgroundColor: 'rgba(76, 173, 80, 0.5)',
                        borderWidth: 1,
                        data: collect(this.rawData).pluck('income').toArray()
                    },
                    {
                        label: this.$t('form.expense'),
                        borderColor: '#F44336',
                        backgroundColor: 'rgba(244, 67, 54, 0.5)',
                        borderWidth: 1,
                        data: collect(this.rawData).pluck('expense').toArray()
                    },
                    {
                        label: this.$t('title.statisticNetWorth'),
                        pointBackgroundColor: 'rgba(0, 0, 0, 0.1)',
                        backgroundColor: 'transparent',
                        type: 'line',
                        data: collect(this.rawData).pluck('worth').toArray()
                    }
                ]
            }
        },
        mounted() {
            this.$store
                .dispatch('statistics/fetch')
                .then(() => {
                    this.loading = false
                })
        }
    }
</script>
