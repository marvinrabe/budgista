<template>
  <Layout :title="account.name">
    <template v-slot:header>
      <div class="mt-4 w-full lg:mt-0 lg:w-auto lg:ml-auto">
        <div class="flex -mx-2">
          <AppNumber
            class="lg:items-end"
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
    </template>

    <template v-slot:actions>
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
    </template>

    <div class="flex -mx-1 mb-4 justify-center sm:justify-start" v-if="futureCount">
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

    <TransactionList :transactions="transactions.data"/>

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
  import Layout from '@/Layouts/Default'
  import AppPagination from '@/Components/AppPagination'

  export default {
    components: {
      AppPagination,
      Layout,
      PlusIcon: iconComponent({ icon: faPlus }),
      CogIcon: iconComponent({ icon: faCog }),
      AppButton,
      AppNumber,
      TransactionList
    },
    props: {
      account: Object,
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
