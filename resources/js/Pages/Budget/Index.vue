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
      <inertia-link
        class="hover:no-underline flex block rounded px-4 py-2 mb-2"
        :class="{'bg-red-7 hover:bg-red-6 text-white hover:text-white': $page.budget.available < 0, 'bg-green-7 hover:bg-green-6 text-white hover:text-white': $page.budget.available > 0, 'bg-gray-3 hover:bg-gray-2 text-gray-6 hover:text-gray-6': $page.budget.available === 0 }"
        :href="$page.budget.links.uncategorized">
        <span class="label">
          {{ $t('budget.title.uncategorized') }}
        </span>
        <AppMoney
          :value="$page.budget.available"
          class="ml-auto pl-2 text-xs font-medium"
        />
      </inertia-link>

      <AppMenu>
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
  import Layout from '@/Layouts/Container'
  import MoneyColumn from '@/Components/MoneyColumn'
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
  import MoneyRow from '@/Components/MoneyRow'

  export default {
    components: {
      MoneyRow,
      AppButton,
      AppMenuItem,
      AppMenu,
      BudgetProgress,
      Layout,
      MoneyColumn,
      AppMoney,
      MonthPicker,
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
