<template>
  <Layout :title="account.name">
    <template v-slot:header>
      <h2 class="text-xl ellipsis">
        <span>{{ account.name }}</span>
      </h2>

      <div class="ml-auto flex">
        <AppButton :to="account.links.edit" icon :title="$t('action.edit.account')">
          <CogIcon/>
        </AppButton>

        <AppButton :to="account.links.transactions.create" variant="primary" :title="$t('action.create.transaction')"
                   class="ml-2">
          <PlusIcon/>
          {{ $t('word.transaction')}}
        </AppButton>
      </div>
    </template>

    <div class="card px-4 py-2 mb-4">
      <div class="flex flex-wrap items-baseline justify-between space-x-2">
        <MoneyColumn
          :color="true"
          :label="$t('form.balance.working')"
          :value="account.balance"
          class="items-start mb-2 lg:mb-0"
        />
        <div class="flex flex-col">
          <MoneyRow :value="account.cleared_balance">
            <template v-slot:label>
              <CheckIcon class="text-green-7 mr-1"/>
              {{ $t('form.balance.cleared')}}
            </template>
          </MoneyRow>
          <MoneyRow :value="account.outstanding_balance">
            <template v-slot:label>
              <CheckIcon class="text-gray-5 mr-1"/>
              {{ $t('form.balance.outstanding')}}
            </template>
          </MoneyRow>
        </div>
      </div>
    </div>

    <div class="flex justify-between items-baseline">
      <h3 class="text-lg mb-2">{{ $t('title.transactions')}}</h3>

      <div class="flex py-4" v-if="futureCount">
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
  import MoneyColumn from '@/Components/MoneyColumn'
  import AppButton from '@/Components/form/AppButton'
  import TransactionList from '@/Components/transactions/TransactionList'
  import { iconComponent } from '@/Utils/Icons'
  import AppPagination from '@/Components/AppPagination'
  import Layout from '@/Layouts/Default'
  import AppMoney from '@/Components/AppMoney'
  import MoneyRow from '@/Components/MoneyRow'

  export default {
    components: {
      MoneyRow,
      AppMoney,
      Layout,
      PlusIcon: iconComponent({ icon: faPlus }),
      CogIcon: iconComponent({ icon: faCog }),
      CheckIcon: iconComponent({ icon: faCheckCircle }),
      AppButton,
      MoneyColumn,
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
