<template>
  <Layout :title="$t('title.budget') + ': ' + monthObject.format()" :redirect="links">
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

      <div class="border-b-2 border-gray-3 px-4 py-2 flex items-center justify-between mb-2">
          <span class="text-xs tracking-wide font-bold uppercase ">
            {{ $t('form.unallocated')}}
          </span>

        <AppMoney
          :value="$page.budget.unallocated"
          :color="$page.budget.unallocated !== 0"
        />
      </div>

      <template v-if="$page.budget.categories.length">
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
                :category="category"
              />
            </div>
          </AppMenuItem>
        </AppMenu>

        <div class="py-2 flex justify-center">
          <inertia-link
            class="pill"
            href="/categories">
            <CogIcon class="text-gray-6"/>
            {{ $t('action.manageCategories') }}
          </inertia-link>
        </div>
      </template>
      <CategoryListEmpty v-else />

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
  import CategoryListEmpty from '@/Components/categories/CategoryListEmpty'
  import { budgetRoute } from '@/Utils/Route'

  export default {
    components: {
      CategoryListEmpty,
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
      links () {
        return this.$page.budget.categories.map(category => category.links.show)
      },
      monthObject () {
        return Month.fromString(this.$page.budget.month.value)
      },
      prevLink() {
        return budgetRoute(this.$page.budget.month.links.prev, this.$page.category)
      },
      nextLink() {
        return budgetRoute(this.$page.budget.month.links.next, this.$page.category)
      }
    },
    methods: {
      sortGroups (result) {
        const ids = result.map(group => group.id).filter(x => x)

        this.$inertia.post('/groups/sort', {
          groups: ids
        }, { preserveScroll: true })
      },
      sortCategories (group, result) {
        const ids = result.map(category => category.id).filter(x => x)

        this.$inertia.post('/categories/sort', {
          group_id: group,
          categories: ids
        }, { preserveScroll: true })
      }
    }
  }
</script>
