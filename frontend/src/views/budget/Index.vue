<template>
    <div class="main">

        <AppToolbar :title="$t('title.budget')">
            <month-picker :month="monthObject" slot="title"></month-picker>

            <BudgetOverview :loading="loading" :month="monthObject"/>

            <template slot="submenu">
                <budget-settings :month="monthObject"></budget-settings>
            </template>
        </AppToolbar>

        <Budget :loading="loading" :month="monthObject"/>

    </div>
</template>

<script>
  import AppToolbar from '../../components/AppToolbar'
  import Budget from '../../components/budget/Budget'
  import BudgetOverview from '../../components/budget/BudgetOverview'
  import BudgetSettings from '../../components/budget/BudgetSettings'
  import MonthPicker from '../../components/budget/MonthPicker'
  import Month from '../../models/Month.js'

  export default {
    props: ['month'],
    components: {
      AppToolbar,
      Budget,
      BudgetOverview,
      BudgetSettings,
      MonthPicker
    },
    computed: {
      monthObject () {
        return Month.fromString(this.month)
      },
      budget: function () {
        return this.$store.getters['budgets/byMonth'](this.monthObject)
      }
    },
    data () {
      return {
        loading: true
      }
    },

    watch: {
      month: {
        immediate: true,
        handler () {
          this.loadSheet(this.monthObject)
        }
      }
    },

    methods: {
      loadSheet (month) {
        this.loading = true

        this.$store
          .dispatch('budgets/fetchSingle', month)
          .then(() => {
            this.loading = false
          })
      }

    }
  }
</script>
