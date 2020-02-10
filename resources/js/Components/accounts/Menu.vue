<template>
  <div class="my-2">
    <div class="d-flex align-items-center" style="margin-right: -.25rem">
      <p class="menu__header">
        {{ $t('title.accounts') }}
      </p>
      <create-account
        class="ml-auto"
        ref="createAccount"
      />
    </div>

    <FadeTransition :duration="250" group mode="out-in">
      <template v-if="loading">
        <MenuSkeleton
          :key="n"
          v-for="n in 3"
        />
      </template>
      <template v-else>
        <menu-item
          :account="account"
          :key="account.id"
          @click.native="$emit('navigate')"
          v-for="account in spendingAccounts"
        />
      </template>
    </FadeTransition>

    <FadeTransition :duration="250" mode="out-in">
      <div v-if="!loading && trackingAccounts.length">
        <p class="menu__header mt-2">
          {{ $t('title.trackingAccounts') }}
        </p>
        <FadeTransition :duration="250" group mode="out-in">
          <menu-item
            :account="account"
            :key="account.id"
            @click.native="$emit('navigate')"
            v-for="account in trackingAccounts"
          />
        </FadeTransition>
      </div>
    </FadeTransition>

  </div>
</template>

<script>
  import FadeTransition from 'vue2-transitions/src/Fade/FadeTransition'
  import CreateAccount from './CreateAccount'
  import MenuItem from './MenuItem'
  import MenuSkeleton from './MenuSkeleton'

  export default {
    components: {
      MenuSkeleton,
      MenuItem,
      CreateAccount,
      FadeTransition
    },
    props: {
      loading: Boolean,
      accounts: Array
    },
    computed: {
      spendingAccounts () {
        return this.accounts
          .filter(account => !account.isTracking)
          .sort((a, b) => a.name.localeCompare(b.name))
      },
      trackingAccounts () {
        return this.accounts
          .filter(account => account.isTracking)
          .sort((a, b) => a.name.localeCompare(b.name))
      }
    }
  }
</script>
