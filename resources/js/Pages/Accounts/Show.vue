<template>
  <Layout>
    <AppToolbar>
      <template slot="title">
        {{ account.name }}
      </template>

      <AccountBalance :account="account" :loading="!account"/>

      <template slot="submenu">
        <inertia-link :href="account.links.edit">
          <CogIcon />
        </inertia-link>

        <AppButton
          :title="$t('action.create.transaction')"
          :to="{ name: 'transaction.new', query: { account: account.id }}"
          variant="primary"
        >
          <PlusIcon/>
          {{ $t('word.transaction') }}
        </AppButton>
      </template>
    </AppToolbar>

    <TransactionList
      :account-id="accountId"
      :loading="!transactions"
      :transactions="transactionList"
    />

    <InfiniteLoading @infinite="showMore" v-if="transactions">
      <span slot="no-more"/>
      <div class="m-3 text-muted" slot="spinner">
        <AppSpinner/>
      </div>
    </InfiniteLoading>
  </Layout>
</template>

<script>
  import { faPlus, faCog } from '@fortawesome/free-solid-svg-icons'
  import InfiniteLoading from 'vue-infinite-loading'
  import AccountBalance from '@/Components/accounts/AccountBalance'
  import AppSpinner from '@/Components/AppSpinner'
  import AppToolbar from '@/Components/AppToolbar'
  import AppButton from '@/Components/form/AppButton'
  import TransactionList from '@/Components/transactions/TransactionList'
  import { iconComponent } from '../../helpers'
  import Layout from '@/Layouts/Default'

  const pageSize = 25

  export default {
    components: {
      Layout,
      PlusIcon: iconComponent({ icon: faPlus }),
      CogIcon: iconComponent({ icon: faCog }),
      AppButton,
      AppSpinner,
      InfiniteLoading,
      AppToolbar,
      AccountBalance,
      TransactionList
    },
    props: {
      account: Object
    },
    metaInfo () {
      return {
        title: this.account.name
      }
    },
    data () {
      return {
        page: 1,
        showMoreEnabled: true,
        transactions: []
      }
    },
    computed: {
      transactionList () {
        if (this.transactions) {
          return this.transactions.data
        }
        return []
      }
    },
    methods: {
      showMore (loader) {
        if (!this.showMoreEnabled && loader) {
          loader.complete()
          return
        }

        this.page++
      }
    }
  }
</script>

<style>
  @media (max-width: 575.98px) {
    .toolbar .balance .numeric:first-child {
      align-items: flex-start !important;
    }
  }
</style>

<style scoped>
  @media (max-width: 575.98px) {
    .toolbar .title {
      order: 1;
    }

    .toolbar .button-right {
      order: 2;
    }

    .toolbar .balance {
      order: 3;
      flex: 100%;
      padding: 0;
      margin-top: .5em;
    }

    .toolbar .balance .numeric {
      text-align: center !important;
    }
  }
</style>

