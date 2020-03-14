<template>
  <div class="h-screen overflow-auto p-2 flex flex-col">
    <AppLogo :height="40" class="mt-2 mb-4 h-10"/>

    <nav class="mb-4">
      <ul class="flex flex-col">
        <AppNavigationItem
          :label="$t('title.budget')"
          :icon="icons.budget"
          href="/budget"
        />
        <AppNavigationItem
          :label="$t('title.statistics')"
          :icon="icons.statistics"
          href="/statistics"
        />
      </ul>
      <p class="label px-4 pt-3 pb-1 text-gray-6">
        {{ $t('title.accounts') }}
      </p>
      <ul>
        <AppNavigationItem
          :label="$t('title.allTransactions')"
          :icon="icons.allTransactions"
          href="/transactions"
        />
        <AppNavigationItem
          :label="account.name"
          :key="account.id"
          :icon="accountIcon(account)"
          :amount="account.balance"
          :href="account.links.show"
          @click.native="$emit('navigate')"
          v-for="account in $page.user.accounts"
        />
        <AppNavigationItem
          :label="$t('action.create.account')"
          :icon="icons.plus"
          href="/accounts/create"
        />
      </ul>
    </nav>
    <nav class="mt-auto">
      <ul>
        <AppNavigationItem
          :label="$t('title.settings')"
          :icon="icons.settings"
          href="/settings"
        />
      </ul>
    </nav>
  </div>
</template>

<script>
  import AppLogo from './AppLogo'
  import AppNavigationItem from '@/Components/AppNavigationItem'
  import {
    faEnvelope,
    faUniversity,
    faChartBar,
    faCog,
    faPlus,
    faInbox,
    faCreditCard
  } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '@/Utils/Icons'
  import AppButton from '@/Components/form/AppButton'
  import { transactionRoute } from '@/Utils/Route'
  import accountIcons from '@/Components/accounts/accountIcons'

  export default {
    components: {
      AppButton,
      AppNavigationItem,
      AppLogo,
      CogIcon: iconComponent({ icon: faCog, fixedWidth: true }),
      PlusIcon: iconComponent({ icon: faPlus }),
    },
    data () {
      return {
        icons: {
          budget: faEnvelope,
          transactions: faUniversity,
          statistics: faChartBar,
          settings: faCog,
          allTransactions: faInbox,
          plus: faPlus
        }
      }
    },
    computed: {
      createTransactionRoute () {
        return transactionRoute(this.$page)
      }
    },
    methods: {
      accountIcon (account) {
        let icon = accountIcons.find(x => x.name === account.icon)
        if (icon) {
          return icon.icon
        }
        return faCreditCard
      }
    }
  }
</script>
