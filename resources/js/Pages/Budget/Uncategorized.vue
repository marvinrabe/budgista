<template>
  <Layout>
    <div class="card">
      <div class="card-header flex justify-between items-center">
        <h2 class="text-xl leading-tight">
          {{ $t('form.uncategorized') }}
        </h2>
      </div>

      <div class="card-body border-b border-gray-3 flex flex-wrap items-baseline justify-center -mx-4">
        <div class="w-full lg:w-3/4 xl:w-1/2 flex flex-col px-4">
          <div class="py-1 flex items-center justify-between">
            <span class="text-xs tracking-wide font-bold uppercase ">
              {{ $t('form.previousMonth')}}
            </span>

            <AppMoney :value="$page.budget.previousMonth" class="text-sm"/>
          </div>
          <div class="py-1 flex items-center justify-between">
            <span class="text-xs tracking-wide font-bold uppercase ">
              {{ $t('form.income')}}
            </span>

            <AppMoney :value="$page.budget.income" class="text-sm"/>
          </div>
          <div class="py-1 flex items-center justify-between">
            <span class="text-xs tracking-wide font-bold uppercase ">
              {{ $t('form.expense')}}
            </span>

            <AppMoney :value="$page.budget.expenses" class="text-sm"/>
          </div>
          <div class="py-1 flex items-center justify-between">
            <span class="text-xs tracking-wide font-bold uppercase ">
              {{ $t('form.allocated')}}
            </span>

            <AppMoney :value="$page.budget.allocated" class="text-sm"/>
          </div>
          <div class="py-1 flex items-center justify-between -mr-4">
            <span class="text-xs tracking-wide font-bold uppercase ">
              {{ $t('form.available')}}
            </span>

            <AppMoney
              :value="$page.budget.available"
              class="badge text-xl"
              :class="{'badge--red': $page.budget.available < 0, 'badge--green': $page.budget.available > 0, 'badge--gray': $page.budget.available === 0, }"
            />
          </div>
        </div>
      </div>
    </div>

    <TransactionList :transactions="transactions.data" />

    <div class="flex items-center justify-end">
      <AppPagination :paginator="transactions"/>
    </div>
  </Layout>
</template>
<script>
  import Layout from '@/Pages/Budget/Index'
  import TransactionList from '@/Components/transactions/TransactionList'
  import AppPagination from '@/Components/AppPagination'
  import AppMoney from '@/Components/AppMoney'

  export default {
    props: {
      transactions: Object
    },
    components: {
      AppMoney,
      AppPagination,
      Layout,
      TransactionList
    }
  }
</script>
