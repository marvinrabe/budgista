<template>
  <Layout :title="$t('title.budget') + ': ' + monthObject.format()" :redirect="$page.budget.links.uncategorized">
    <template v-slot:menu>

      <div class="flex items-center mb-4">
          <span class="text-gray-8 text-xl px-4">
            {{ monthObject.format() }}
          </span>
        <div class="flex ml-auto">
          <inertia-link
            :title="$t('action.previousMonth')"
            :href="prevLink"
            class="btn btn--icon"
          >
            <PrevIcon/>
          </inertia-link>
          <inertia-link
            :title="$t('action.nextMonth')"
            :href="nextLink"
            class="btn btn--icon"
          >
            <NextIcon/>
          </inertia-link>
          <AppButton
            :to="'/tabularBudget/'+monthObject.toString()"
            class="hidden md:block"
            icon>
            <TableIcon/>
          </AppButton>
        </div>
      </div>

      <AppMenu>
        <AppMenuItem class="border-b-2" :label="$t('form.uncategorized')" :href="$page.budget.links.uncategorized">
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
  import { faChevronLeft, faChevronRight, faCog, faTable } from '@fortawesome/free-solid-svg-icons'
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
      NextIcon: iconComponent({ icon: faChevronRight, fixedWidth: true }),
      PrevIcon: iconComponent({ icon: faChevronLeft, fixedWidth: true }),
      CogIcon: iconComponent({ icon: faCog }),
    },
    props: {
      title: {
        type: String,
        default: null
      }
    },
    computed: {
      monthObject () {
        return Month.fromString(this.$page.budget.month.value)
      },
      prevLink () {
        return budgetRoute(this.$page.budget.links.prev, this.$page.category)
      },
      nextLink () {
        return budgetRoute(this.$page.budget.links.next, this.$page.category)
      }
    }
  }
</script>
