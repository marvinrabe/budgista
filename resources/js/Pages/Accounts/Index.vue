<template>
  <Layout :title="$t('title.accounts')" :redirect="links">
    <template v-slot:menu>
      <h2 class="text-xl mb-4 px-4">
        {{ $t('title.accounts') }}
      </h2>

      <template v-if="$page.user.accounts.length">
        <AppMenu>
          <menu-item
            :account="account"
            :key="account.id"
            @click.native="$emit('navigate')"
            v-for="account in spendingAccounts"
          />
        </AppMenu>

        <AppMenu
          v-if="trackingAccounts.length"
          :title="$t('title.trackingAccounts')">
          <menu-item
            :account="account"
            :key="account.id"
            @click.native="$emit('navigate')"
            v-for="account in trackingAccounts"
          />
        </AppMenu>

        <div class="py-2 flex justify-center">
          <inertia-link
            class="pill"
            href="/accounts/create">
            <PlusIcon class="text-gray-6"/>
            {{ $t('action.create.account') }}
          </inertia-link>
        </div>
      </template>
      <AccountListEmpty v-else/>

    </template>

    <slot/>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Container'
  import MenuItem from '@/Components/accounts/MenuItem'
  import AppButton from '@/Components/form/AppButton'
  import AppMenu from '@/Components/AppMenu'
  import { iconComponent } from '@/Utils/Icons'
  import { faPlus } from '@fortawesome/free-solid-svg-icons'
  import AppMenuItem from '@/Components/AppMenuItem'
  import AccountListEmpty from '@/Components/accounts/AccountListEmpty'

  export default {
    components: {
      AccountListEmpty,
      AppMenuItem,
      AppButton,
      AppMenu,
      Layout,
      MenuItem,
      PlusIcon: iconComponent({ icon: faPlus }),
    },
    computed: {
      links () {
        return this.$page.user.accounts.map(account => account.links.show)
      },
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
    }
  }
</script>
