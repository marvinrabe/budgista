<template>
  <Layout :title="$t('title.budget') + ': ' + monthObject.format()">
    <template v-slot:menu>

      <div class="flex items-center mb-4">
          <span class="text-gray-8 text-xl px-4">
            {{ monthObject.format() }}
          </span>
        <div class="flex ml-auto">
          <inertia-link
            :title="$t('action.previousMonth')"
            :href="$page.budget.month.links.prev"
            class="btn btn--icon"
          >
            <PrevIcon/>
          </inertia-link>
          <inertia-link
            :title="$t('action.nextMonth')"
            :href="$page.budget.month.links.next"
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
              :activity="-category.activity"
              :total="category.budget"/>
          </div>
        </AppMenuItem>
      </AppMenu>
    </template>

    <slot/>
  </Layout>
</template>

<script>
  import draggable from 'vuedraggable'
  import Layout from '@/Layouts/Default'
  import AppNumber from '@/Components/AppNumber'
  import AppMoney from '@/Components/AppMoney'
  import MonthPicker from '@/Components/budget/MonthPicker'
  import Month from '@/Utils/Month.js'
  import BudgetProgress from '@/Components/budget/BudgetProgress'
  import AppMenu from '@/Components/AppMenu'
  import AppMenuItem from '@/Components/AppMenuItem'
  import AppButton from '@/Components/form/AppButton'
  import { iconComponent } from '@/Utils/Icons'
  import { faChevronLeft, faChevronRight, faTable } from '@fortawesome/free-solid-svg-icons'

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
      PrevIcon: iconComponent({ icon: faChevronLeft, fixedWidth: true })
    },
    mounted () {
      if (window.innerWidth >= 768 && !this.$slots.default && this.$page.budget.categories.length) {
        this.$inertia.visit(this.$page.budget.categories[0].links.show, { replace: true })
      }
    },
    computed: {
      monthObject () {
        return Month.fromString(this.$page.budget.month.value)
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
