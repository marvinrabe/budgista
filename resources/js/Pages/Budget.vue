<template>
  <Layout :title="$t('title.budget') + ': ' + monthObject.format()">
    <template v-slot:title>
      <MonthPicker
        :month="monthObject"
        :next="links.next"
        :prev="links.prev"
        slot="title"
      />
    </template>

    <template v-slot:header>
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
            :label="$t('form.unallocated')"
            :value="budget.unallocated"
            class="items-end"
            color
          />
        </div>
      </div>
    </template>

    <template v-slot:actions>
      <BudgetSettings/>
    </template>

    <Budget>
      <draggable
        handle=".budget-group-handle"
        group="groups"
        class="budget-groups"
        v-model="groups"
        @input="sortGroups"
      >
        <BudgetGroup
          :budget="budget"
          :group="group"
          :key="group.id"
          v-for="group in groups"
        >
          <draggable
            handle=".budget-row-handle"
            :group="'categories-'+group.id"
            class="budget-categories"
            v-model="group.categories"
            @input="(l) => sortCategories(group.id, l)"
          >
            <BudgetCategory
              :month="monthObject"
              :category="category"
              :budget="budget"
              :key="category.id"
              v-for="category in group.categories"
            />
          </draggable>
        </BudgetGroup>
      </draggable>
    </Budget>
  </Layout>
</template>

<script>
  import draggable from 'vuedraggable'
  import Layout from '@/Layouts/Default'
  import AppNumber from '@/Components/AppNumber'
  import Budget from '@/Components/budget/Budget'
  import BudgetCategory from '@/Components/budget/BudgetCategory'
  import BudgetGroup from '@/Components/budget/BudgetGroup'
  import BudgetSettings from '@/Components/budget/BudgetSettings'
  import MonthPicker from '@/Components/budget/MonthPicker'
  import Month from '@/Utils/Month.js'

  export default {
    components: {
      Layout,
      AppNumber,
      Budget,
      BudgetCategory,
      BudgetGroup,
      BudgetSettings,
      MonthPicker,
      draggable
    },
    props: {
      month: String,
      budget: Object,
      links: Object,
      groups: Array
    },
    computed: {
      monthObject () {
        return Month.fromString(this.month)
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
