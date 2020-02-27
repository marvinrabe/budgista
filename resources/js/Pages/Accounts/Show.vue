<template>
  <Layout :title="account.name">
    <div class="card ">
      <div class="card-header flex items-center">
        <h2 class="text-xl text-gray-8">
          {{ account.name }}
        </h2>

        <div class="ml-auto flex">
          <AppButton :to="account.links.edit" icon>
            <CogIcon/>
          </AppButton>

          <AppButton
            :title="$t('action.create.transaction')"
            :to="account.links.transactions.create"
            variant="primary"
          >
            <PlusIcon/>
            {{ $t('word.transaction') }}
          </AppButton>
        </div>
      </div>

      <div class="card-body flex -mx-4">
        <AppNumber
          :color="true"
          :label="$t('form.balance.cleared')"
          :value="account.balance_cleared"
        />
        <AppNumber
          class="items-end"
          :color="true"
          :label="$t('form.balance.working')"
          :value="account.balance"
        />
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
      column="category"
    />

    <div class="flex items-center justify-end">
      <AppPagination :paginator="transactions"/>
    </div>
  </Layout>
</template>

<script>
  import { faPlus, faCog } from '@fortawesome/free-solid-svg-icons'
  import AppNumber from '@/Components/AppNumber'
  import AppButton from '@/Components/form/AppButton'
  import TransactionList from '@/Components/transactions/TransactionList'
  import { iconComponent } from '@/Utils/Icons'
  import AppPagination from '@/Components/AppPagination'
  import Layout from '@/Pages/Accounts/Index'

  export default {
    components: {
      Layout,
      PlusIcon: iconComponent({ icon: faPlus }),
      CogIcon: iconComponent({ icon: faCog }),
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
