<template>
  <div class="border-b border-gray-3 hover:bg-gray-0 flex items-baseline">
    <inertia-link
      :href="transaction.links.edit"
      class="flex flex-1 min-w-0 flex-col px-4 py-3 hover:no-underline"
    >
      <div class="w-full flex justify-between">
        <div class="ellipsis text-gray-8 mr-2">
          <span>{{ transaction.payee }}</span>
        </div>

        <AppMoney :value="transaction.amount" color/>
      </div>
      <div class="w-full flex justify-between text-sm text-gray-6 font-weigh-medium tracking-wide">
        <div class="mr-2">
          <DateFormat :value="transaction.date"/>
          <RecurringIcon :value="transaction.recurrence" class="ml-1"/>
        </div>

        <div class="text-right ellipsis">
          <span v-if="transaction.account && transaction.target_account">
            <span class="text-xs">{{ transaction.target_account.name }} &rarr;</span>
            {{ transaction.account.name }}
          </span>
          <span v-else-if="transaction.target_account">
            {{ transaction.target_account.name }}
          </span>
          <span v-else>
            <template v-if="(column === 'account'|| !column) && transaction.account">
              {{ transaction.account.name }}
            </template>
            <template v-if="!column">&middot;</template>
            <template v-if="column === 'category' || !column">
              <template v-if="transaction.category">{{ transaction.category.name }}</template>
              <template v-else-if="transaction.amount > 0">{{ $t('form.income')}}</template>
              <template v-else>{{ $t('form.uncategorized')}}</template>
            </template>
          </span>
        </div>
      </div>
    </inertia-link>
    <div class="pl-0 pr-4 py-3" v-if="withState && !isFuture">
      <ClearInput :transaction="transaction"/>
    </div>
  </div>
</template>

<script>
  import dayjs from 'dayjs'
  import AppMoney from '../AppMoney'
  import DateFormat from '../DateFormat'
  import ClearInput from './ClearInput'
  import RecurringIcon from './RecurringIcon'

  export default {
    components: {
      AppMoney,
      ClearInput,
      DateFormat,
      RecurringIcon
    },
    props: {
      transaction: Object,
      withState: {
        type: Boolean,
        default: false
      },
      column: {
        type: String,
        default: null,
      }
    },
    computed: {
      isFuture () {
        return dayjs(this.transaction.date).isAfter()
      }
    }
  }
</script>
