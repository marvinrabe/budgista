<template>
  <Layout>

    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">
          {{ category.name }}
        </h2>
      </div>

      <div class="card-body border-b border-gray-3 flex flex-wrap">
        <FormGroup
          name="amount"
          label="budget"
          class="mb-0">
          <AppMoneyInput
            :value="categoryBudget.budget"
            @change="val => updateBudget(val)"
            allow-negative
          />
        </FormGroup>
      </div>
    </div>

    <TransactionList
      :transactions="transactions.data"
      column="account"
    />

    <div class="flex items-center justify-end">
      <AppPagination :paginator="transactions"/>
    </div>
  </Layout>
</template>
<script>
  import Layout from '@/Pages/Budget/Index'
  import FormGroup from '@/Components/form/FormGroup'
  import TransactionList from '@/Components/transactions/TransactionList'
  import AppMoneyInput from '@/Components/form/AppMoneyInput'
  import AppPagination from '@/Components/AppPagination'

  export default {
    props: {
      category: Object,
      categoryBudget: Object,
      transactions: Object
    },
    components: {
      AppMoneyInput,
      AppPagination,
      FormGroup,
      Layout,
      TransactionList
    },
    methods: {
      updateBudget (value) {
        this.$inertia
          .post(`/budget/${this.$page.budget.month.value}/categories/${this.category.id}`, {
            amount: value
          }, { preserveScroll: true })
      }
    }
  }
</script>
