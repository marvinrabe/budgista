<template>
  <div class="my-2">
    <div class="flex items-center justify-between">
      <p class="menu__header">
        {{ $t('title.accounts') }}
      </p>
      <AppButton to="/accounts/create" class="text-gray-6" icon small :title="$t('action.create.account')">
        <PlusIcon />
      </AppButton>
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
  import AppButton from '@/Components/form/AppButton'
  import { iconComponent } from '@/Utils/Icons'
  import { faPlus } from '@fortawesome/free-solid-svg-icons'

  export default {
    components: {
      AppButton,
      MenuItem,
      PlusIcon: iconComponent({ icon: faPlus }),
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
