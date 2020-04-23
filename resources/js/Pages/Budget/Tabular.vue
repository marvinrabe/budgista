<template>
  <Layout :title="$t('title.budget') + ': ' + month.format()">
    <template v-slot:header>
      <MonthPicker :value="month" @input="changeMonth"/>

      <div class="mt-4 w-full lg:mt-0 lg:w-auto lg:ml-auto">
        <div class="flex -mx-2">
          <AppNumber
            :label="$t('form.previousMonth')"
            :value="budget.previousMonth"
            class="hidden md:flex items-start lg:items-end"
          />
          <AppNumber
            :label="$t('form.income')"
            :value="budget.income"
            class="items-start md:items-center lg:items-end"
          />
          <AppNumber
            :label="$t('form.expense')"
            :value="budget.expenses"
            class="items-start md:items-center lg:items-end"
          />
          <AppNumber
            :label="$t('form.available')"
            :value="budget.available"
            class="items-end"
            color
          />
        </div>
      </div>
    </template>

    <template v-if="budget.categories.length">
      <Budget>
        <BudgetCategory
          :month="month"
          :category="category"
          :key="category.id"
          v-for="category in budget.categories"
        />
      </Budget>

      <div class="py-2 flex">
        <inertia-link
          class="pill"
          href="/categories">
          <CogIcon class="text-gray-6"/>
          {{ $t('action.manageCategories') }}
        </inertia-link>
      </div>
    </template>
    <CategoryListEmpty v-else/>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppNumber from '@/Components/AppNumber'
  import Budget from '@/Components/budget/Budget'
  import BudgetCategory from '@/Components/budget/BudgetCategory'
  import MonthPicker from '@/Components/budget/MonthPicker'
  import Month from '@/Utils/Month.js'
  import AppButton from '@/Components/form/AppButton'
  import { iconComponent } from '@/Utils/Icons'
  import { faCog } from '@fortawesome/free-solid-svg-icons'
  import CategoryListEmpty from '@/Components/categories/CategoryListEmpty'
  import { budgetRoute } from '@/Utils/Route'

  export default {
    components: {
      CategoryListEmpty,
      AppButton,
      Layout,
      AppNumber,
      Budget,
      BudgetCategory,
      MonthPicker,
      CogIcon: iconComponent({ icon: faCog }),
    },
    props: {
      budget: Object
    },
    data () {
      return {
        month: Month.fromString(this.budget.month.value)
      }
    },
    methods: {
      changeMonth (month) {
        this.$inertia.visit(budgetRoute('/tabularBudget', month))
      }
    }
  }
</script>
