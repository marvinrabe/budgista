<template>
    <div class="card">
        <div class="card-header" v-t="'title.statisticNetWorth'"></div>
        <div class="card-body">
            <div class="flex flex-column justify-content-center align-items-stretch">
                <app-spinner v-if="loading"></app-spinner>
                <net-worth-chart v-else :datasets="datasets" :labels="labels"></net-worth-chart>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import collect from 'collect.js'
    import Month from '../../models/Month'
    import NetWorthChart from './NetWorthChart'

    export default {
        components: {
            NetWorthChart
        },
        data() {
            return {
                labels: [],
                datasets: {},
                loading: true
            }
        },
        mounted() {
            axios.get('/statistics/monthly')
                .then(({data}) => {
                    this.prepareData(data.data)
                    this.loading = false
                })
        },
        methods: {
            prepareData(data) {
                this.labels = collect(data).map((x) => Month.fromString(x.month).format()).toArray()
                this.datasets = [
                    {
                        label: this.$t('form.income'),
                        borderColor: '#4CAF50',
                        backgroundColor: 'rgba(76, 173, 80, 0.5)',
                        borderWidth: 1,
                        data: collect(data).pluck('income').toArray()
                    },
                    {
                        label: this.$t('form.expense'),
                        borderColor: '#F44336',
                        backgroundColor: 'rgba(244, 67, 54, 0.5)',
                        borderWidth: 1,
                        data: collect(data).pluck('expense').toArray()
                    },
                    {
                        label: this.$t('title.statisticNetWorth'),
                        pointBackgroundColor: 'rgba(0, 0, 0, 0.1)',
                        backgroundColor: 'transparent',
                        type: 'line',
                        data: collect(data).pluck('worth').toArray()
                    }
                ]
            }
        }
    }
</script>
