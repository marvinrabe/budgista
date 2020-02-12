<template>
  <Layout>
    <AppToolbar :title="$t('title.budget')">
      <MonthPicker
        :month="monthObject"
        :next="links.next"
        :prev="links.prev"
        slot="title"
      />

      <BudgetOverview :budget="budget"/>

      <template slot="submenu">
        <BudgetSettings/>
      </template>
    </AppToolbar>

    <Budget>
      <draggable
        :class="{'budget-groups--drag': drag}"
        :options="{handle:'.budget-group-handle', group: 'groups'}"
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
            :options="{handle:'.budget-row-handle', group: 'categories'}"
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
  import AppToolbar from '@/Components/AppToolbar'
  import Budget from '@/Components/budget/Budget'
  import BudgetCategory from '@/Components/budget/BudgetCategory'
  import BudgetGroup from '@/Components/budget/BudgetGroup'
  import BudgetOverview from '@/Components/budget/BudgetOverview'
  import BudgetSettings from '@/Components/budget/BudgetSettings'
  import MonthPicker from '@/Components/budget/MonthPicker'
  import Month from '@/Utils/Month.js'

  export default {
    components: {
      Layout,
      AppToolbar,
      Budget,
      BudgetCategory,
      BudgetGroup,
      BudgetOverview,
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
    metaInfo () {
      return {
        title: this.$t('title.budget')
      }
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
