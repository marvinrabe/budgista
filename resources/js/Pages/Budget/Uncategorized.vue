<template>
  <Layout>
    <div class="card">
      <div class="card-header border-0 flex justify-between items-center">
        <h2 class="text-xl leading-tight">
          {{ $t('budget.title.uncategorized') }}
        </h2>

        <AppDropDown class="ml-auto" body-class="flex-col right-0 top-0 mt-10 whitespace-no-wrap">
          <template v-slot:activator>
            <div
              class="badge border border-transparent px-4 py-2 text-right"
              :class="{'badge--red': $page.budget.available < 0, 'badge--green': $page.budget.available > 0, 'badge--gray': $page.budget.available === 0, }"
            >
              <InfoIcon class="text-sm opacity-50 hover:opacity-75"/>
              <AppMoney class="ml-2" color :value="$page.budget.available"/>
            </div>
          </template>

          <div class="py-1 flex items-center justify-between">
            <span class="label mr-6">
              {{ $t('form.previousMonth')}}
            </span>

            <AppMoney :value="$page.budget.previousMonth" class="text-sm"/>
          </div>
          <div class="py-1 flex items-center justify-between">
            <span class="label mr-6 ">
              {{ $t('form.income')}}
            </span>

            <AppMoney :value="$page.budget.income" class="text-sm"/>
          </div>
          <div class="py-1 flex items-center justify-between">
            <span class="label mr-6 ">
              {{ $t('form.expense')}}
            </span>

            <AppMoney :value="$page.budget.expenses" class="text-sm"/>
          </div>
          <div class="py-1 flex items-center justify-between">
            <span class="label mr-6 ">
              {{ $t('form.allocated')}}
            </span>

            <AppMoney :value="$page.budget.allocated" class="text-sm"/>
          </div>
          <div class="py-1 flex items-center justify-between">
            <span class="label mr-6">
              {{ $t('form.available')}}
            </span>

            <AppMoney :value="$page.budget.available" class="text-sm"/>
          </div>
        </AppDropDown>
      </div>
    </div>

    <h3 class="text-lg mb-2">{{ $t('title.transactions')}}</h3>

    <TransactionList :transactions="transactions.data"/>

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
  import AppDropDown from '@/Components/AppDropDown'
  import { iconComponent } from '@/Utils/Icons'
  import { faInfoCircle } from '@fortawesome/free-solid-svg-icons'

  export default {
    props: {
      transactions: Object
    },
    components: {
      AppDropDown,
      AppMoney,
      AppPagination,
      Layout,
      TransactionList,
      InfoIcon: iconComponent({ icon: faInfoCircle }),
    }
  }
</script>
