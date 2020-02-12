<template>
  <div
    :class="[{ 'transactions-row-future': isFuture }]"
    class="transactions-row"
  >
    <inertia-link
      :href="transaction.links.edit"
      class="transaction-item"
    >
      <span class="transaction-date">
        <DateFormat :value="transaction.date"/>
        <RecurringIcon :value="transaction.recurrence" class="ml-1"/>
      </span>
      <span class="transaction-payee ellipsis">
        {{ transaction.payee }}
      </span>
      <span class="transaction-category ellipsis" v-if="transaction.category">
        {{ transaction.category.name }}
      </span>
      <span class="transaction-category ellipsis" v-else>
        {{ $t('form.uncategorized') }}
      </span>
      <span class="transaction-amount">
        <AppMoney :value="transaction.amount" color/>
      </span>
    </inertia-link>
    <div class="transaction-clear">
      <ClearInput :transaction="transaction" v-if="!isFuture"/>
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
      transaction: {
        type: Object,
        required: true
      }
    },
    computed: {
      isFuture () {
        return dayjs(this.transaction.date).isAfter()
      }
    }
  }
</script>
