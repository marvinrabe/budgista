<template>
  <Layout
    :title="$t('title.budget') + ': ' + month.format()"
    :redirect="$page.budget.links.uncategorized"
    :has-content="!!this.$slots.default"
  >
    <template v-slot:header>
      <MonthPicker :value="month" @input="changeMonth"/>

      <div class="flex ml-auto">
        <AppButton
          :to="'/tabularBudget/'+month.toString()"
          class="hidden md:block"
          icon>
          <TableIcon/>
        </AppButton>
      </div>
    </template>

    <template v-slot:menu>
      <AppMenu>
        <AppMenuItem class="border-b-2" :label="$t('budget.title.uncategorized')"
                     :href="$page.budget.links.uncategorized">
          <AppMoney
            :value="$page.budget.available"
            :color="$page.budget.available !== 0"
            class="ml-auto pl-2 text-xs font-medium"
            color
          />
          <div class="w-full flex justify-end">
            <BudgetProgress
              class="w-1/4"
              :activity="$page.budget.expenses"
              :budget="$page.budget.available - $page.budget.expenses"
              :available="$page.budget.available"
            />
          </div>
        </AppMenuItem>
        <AppMenuItem
          v-for="category in $page.budget.categories"
          :key="category.id"
          :label="category.name"
          :href="category.links.show">
          <AppMoney
            :value="category.available"
            class="ml-auto pl-2 text-xs font-medium"
            color
          />
          <div class="w-full flex justify-end">
            <BudgetProgress
              class="w-1/4"
              :activity="category.activity"
              :budget="category.budget"
              :available="category.available"
            />
          </div>
        </AppMenuItem>
      </AppMenu>

      <div class="flex justify-center">
        <inertia-link
          class="pill"
          href="/categories">
          <CogIcon class="text-gray-6"/>
          {{ $t('action.manageCategories') }}
        </inertia-link>
      </div>
    </template>
    <slot/>
  </Layout>
</template>

<script>
  import draggable from 'vuedraggable'
  import Layout from '@/Layouts/Container'
  import AppNumber from '@/Components/AppNumber'
  import AppMoney from '@/Components/AppMoney'
  import MonthPicker from '@/Components/budget/MonthPicker'
  import Month from '@/Utils/Month.js'
  import BudgetProgress from '@/Components/budget/BudgetProgress'
  import AppMenu from '@/Components/AppMenu'
  import AppMenuItem from '@/Components/AppMenuItem'
  import AppButton from '@/Components/form/AppButton'
  import { iconComponent } from '@/Utils/Icons'
  import { faCog, faTable } from '@fortawesome/free-solid-svg-icons'
  import { budgetRoute } from '@/Utils/Route'

  export default {
    components: {
      AppButton,
      AppMenuItem,
      AppMenu,
      BudgetProgress,
      Layout,
      AppNumber,
      AppMoney,
      MonthPicker,
      draggable,
      TableIcon: iconComponent({ icon: faTable }),
      CogIcon: iconComponent({ icon: faCog }),
    },
    props: {
      title: {
        type: String,
        default: null
      }
    },
    data () {
      return {
        month: Month.fromString(this.$page.budget.month.value)
      }
    },
    methods: {
      changeMonth (month) {
        this.$inertia.visit(budgetRoute('/budget', month, this.$page.category))
      }
    }
  }
</script>
