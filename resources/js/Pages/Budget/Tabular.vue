<template>
  <Layout :title="$t('title.budget') + ': ' + monthObject.format()">
    <div class="flex items-center flex-wrap justify-between mb-4">
      <MonthPicker
        :month="monthObject"
        :next="links.next"
        :prev="links.prev"
        slot="title"
      />

      <div class="lg:order-last flex">
        <AppButton :to="'/budget/'+monthObject.toString()" icon>
          <ListIcon/>
        </AppButton>
      </div>

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
            :label="$t('form.available')"
            :value="budget.available"
            class="items-end"
            color
          />
        </div>
      </div>
    </div>

    <template v-if="budget.categories.length">
      <Budget class="card">
        <BudgetCategory
          :month="monthObject"
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
  import { faThLarge, faCog } from '@fortawesome/free-solid-svg-icons'
  import CategoryListEmpty from '@/Components/categories/CategoryListEmpty'

  export default {
    components: {
      CategoryListEmpty,
      AppButton,
      Layout,
      AppNumber,
      Budget,
      BudgetCategory,
      MonthPicker,
      ListIcon: iconComponent({ icon: faThLarge }),
      CogIcon: iconComponent({ icon: faCog }),
    },
    props: {
      budget: Object,
      links: Object
    },
    computed: {
      monthObject () {
        return Month.fromString(this.budget.month.value)
      }
    }
  }
</script>
