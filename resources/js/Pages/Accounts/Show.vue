<template>
  <Layout :title="account.name">
    <template v-slot:header>
      <div class="flex px-4 -mx-2 mt-4 w-full lg:mt-0 lg:w-auto lg:ml-auto">
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
  import { iconComponent } from '@/helpers'
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
      transactions: Object
    }
  }
</script>
