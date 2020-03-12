<template>
  <Layout :title="account.name">
    <div class="card ">
      <div class="card-header flex items-center">
        <h2 class="text-xl ellipsis">
          <span>{{ account.name }}</span>
        </h2>

        <div class="ml-auto flex">
          <AppButton :to="account.links.edit" icon :title="$t('action.edit.account')">
            <CogIcon/>
          </AppButton>
        </div>
      </div>

      <div class="card-body flex flex-wrap items-baseline -mx-4">
        <AppNumber
          :color="true"
          :label="$t('form.balance.working')"
          :value="account.balance"
          class="md:order-2 items-end"
        />
        <div class="md:order-1 w-full md:w-auto flex flex-col px-4">
          <div class="py-1 flex items-center justify-between">
            <span class="label mr-8">
              <CheckIcon class="text-green-7 mr-1"/>
              {{ $t('form.balance.cleared')}}
            </span>

            <AppMoney :value="account.cleared_balance" class="text-sm"/>
          </div>
          <div class="py-1 flex items-center justify-between">
            <span class="label mr-8">
              <CheckIcon class="text-gray-5 mr-1"/>
              {{ $t('form.balance.outstanding')}}
            </span>

            <AppMoney :value="account.outstanding_balance" class="text-sm"/>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-center sm:justify-start py-4" v-if="futureCount">
      <div class="px-1">
        <inertia-link
          class="pill"
          :class="{'pill--active': !showFuture}"
          :href="account.links.show">
          {{ $t('action.current') }}
        </inertia-link>
      </div>

      <div class="px-1">
        <inertia-link
          class="pill"
          :href="account.links.future"
          :class="{'pill--active': showFuture}">
          {{ $tc('action.futureTransactions', futureCount, { count: futureCount }) }}
        </inertia-link>
      </div>
    </div>

    <TransactionList
      :transactions="transactions.data"
      with-state
      column="category"
    />

    <div class="flex items-center justify-end">
      <AppPagination :paginator="transactions"/>
    </div>
  </Layout>
</template>

<script>
  import { faPlus, faCog, faCheckCircle } from '@fortawesome/free-solid-svg-icons'
  import AppNumber from '@/Components/AppNumber'
  import AppButton from '@/Components/form/AppButton'
  import TransactionList from '@/Components/transactions/TransactionList'
  import { iconComponent } from '@/Utils/Icons'
  import AppPagination from '@/Components/AppPagination'
  import Layout from '@/Pages/Accounts/Index'
  import AppMoney from '@/Components/AppMoney'

  export default {
    components: {
      AppMoney,
      Layout,
      PlusIcon: iconComponent({ icon: faPlus }),
      CogIcon: iconComponent({ icon: faCog }),
      CheckIcon: iconComponent({ icon: faCheckCircle }),
      AppButton,
      AppNumber,
      AppPagination,
      TransactionList
    },
    props: {
      account: Object,
      accounts: Array,
      transactions: Object,
      futureCount: Number
    },
    computed: {
      showFuture () {
        return this.$inertia.page.url.startsWith(this.account.links.future)
      }
    }
  }
</script>
