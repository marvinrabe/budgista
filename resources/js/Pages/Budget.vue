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
      <div class="flex px-4 -mx-2 mt-4 w-full lg:mt-0 lg:w-auto lg:ml-auto">
        <AppNumber
          :label="$t('form.previousMonth')"
          :value="budget.previousMonth"
          class="items-start lg:items-end"
        />
        <AppNumber
          :label="$t('form.income')"
          :value="budget.income"
          class="items-center lg:items-end"
        />
        <AppNumber
          :label="$t('form.unallocated')"
          :value="budget.unallocated"
          class="items-end"
          color
        />
      </div>
    </template>

    <template v-slot:actions>
      <BudgetSettings/>
    </template>

    <Budget>
      <draggable
        :class="{'budget-groups--drag': drag}"
        handle=".budget-group-handle"
        group="groups"
        :value="this.groups"
        @end="drag=false"
        @input="sortGroups"
        @start="drag=true"
        class="budget-groups"
      >
        <BudgetGroup
          :budget="budget"
          :group="group"
          :key="group.id"
          v-for="group in this.groups"
        >
          <draggable
            handle=".budget-row-handle"
            group="categories"
            class="budget-categories"
          >
            <BudgetCategory
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
    data () {
      return {
        loading: true,
        drag: false
      }
    },
    computed: {
      monthObject () {
        return Month.fromString(this.month)
      }
    },
    methods: {
      sortGroups (result) {
        const ids = result.map(group => group.id).filter(x => x)

        /*this.$apollo
          .mutate({
            mutation: require('../../gql/mutation/groupSort.gql'),
            variables: { ids },
            optimisticResponse: {
              __typename: 'Mutation',
              groupSort: this.groups.map(group => {
                if (group.id === null) {
                  return {
                    ...group,
                    sort: ids.length
                  }
                }
                return {
                  ...group,
                  sort: ids.findIndex(id => id === group.id)
                }
              }).sort(group => group.sort)
            }
          })*/
      }
    }
  }
</script>
