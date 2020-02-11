<template>
  <div class="my-2">
    <div class="d-flex align-items-center" style="margin-right: -.25rem">
      <p class="menu__header">
        {{ $t('title.accounts') }}
      </p>
    </div>

    <menu-item
      :account="account"
      :key="account.id"
      @click.native="$emit('navigate')"
      v-for="account in spendingAccounts"
    />

    <div v-if="trackingAccounts.length">
      <p class="menu__header mt-2">
        {{ $t('title.trackingAccounts') }}
      </p>
      <menu-item
        :account="account"
        :key="account.id"
        @click.native="$emit('navigate')"
        v-for="account in trackingAccounts"
      />
    </div>

  </div>
</template>

<script>
  import MenuItem from '@/Components/accounts/MenuItem'

  export default {
    components: {
      MenuItem
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
    }
  }
</script>
