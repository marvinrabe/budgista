<template>
  <div class="h-screen overflow-auto px-2 flex flex-col">
    <AppLogo :height="40" class="my-4 h-10"/>
    <nav class="mb-4">
      <ul class="flex flex-col">
        <AppNavigationItem
          :label="$t('welcome.title')"
          :icon="icons.welcome"
          href="/welcome"
          v-if="$page.user.subscription_state === 'trial'"
        />
        <AppNavigationItem
          :label="$t('title.budget')"
          :icon="icons.budget"
          href="/budget"
        />
        <AppNavigationItem
          :label="$t('title.reports')"
          :icon="icons.reports"
          href="/reports"
        />
        <AppNavigationItem
          :label="$t('title.allTransactions')"
          :icon="icons.allTransactions"
          href="/transactions"
        />
      </ul>
      <p class="label px-4 pt-3 pb-1 text-gray-4">
        {{ $t('title.accounts') }}
      </p>
      <ul>
        <AppNavigationItem
          :label="account.name"
          :key="account.id"
          :icon="accountIcon(account)"
          :amount="account.balance"
          :href="account.links.show"
          @click.native="$emit('navigate')"
          v-for="account in spendingAccounts"
        />
      </ul>
      <template v-if="trackingAccounts.length">
        <p class="label px-4 pt-3 pb-1 text-gray-4">
          {{ $t('title.trackingAccounts') }}
        </p>
        <ul>
          <AppNavigationItem
            :label="account.name"
            :key="account.id"
            :icon="accountIcon(account)"
            :amount="account.balance"
            :href="account.links.show"
            @click.native="$emit('navigate')"
            v-for="account in trackingAccounts"
          />
        </ul>
      </template>
      <ul>
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
    faLightbulb,
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
      CogIcon: iconComponent({ icon: faCog }),
      PlusIcon: iconComponent({ icon: faPlus }),
    },
    data () {
      return {
        icons: {
          welcome: faLightbulb,
          budget: faEnvelope,
          transactions: faUniversity,
          reports: faChartBar,
          settings: faCog,
          allTransactions: faInbox,
          plus: faPlus
        }
      }
    },
    computed: {
      spendingAccounts () {
        return this.$page.user.accounts
          .filter(account => !account.tracking)
          .sort((a, b) => a.name.localeCompare(b.name))
      },
      trackingAccounts () {
        return this.$page.user.accounts
          .filter(account => account.tracking)
          .sort((a, b) => a.name.localeCompare(b.name))
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
