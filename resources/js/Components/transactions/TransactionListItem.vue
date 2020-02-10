<template>
  <div
    :class="[{ 'transactions-row-future': isFuture }]"
    class="transactions-row"
  >
    <router-link
      :to="{ name: 'transaction.edit', params: { transactionId: transaction.id }}"
      class="transaction-item"
    >
      <span class="transaction-date">
        <DateFormat :value="transaction.date"/>
        <RecurringIcon :value="transaction.recurrence" class="ml-1"/>
      </span>
      <span class="transaction-payee ellipsis">
        {{ payee.name }}
      </span>
      <span class="transaction-category ellipsis">
        {{ categories }}
      </span>
      <span class="transaction-amount">
        <AppMoney :value="amount" color/>
      </span>
    </router-link>
    <div class="transaction-clear">
      <ClearInput
        :subject="accountSubject"
        :transaction-id="transaction.id"
        v-if="!isFuture"
      />
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
      },
      accountId: {
        type: String,
        required: true
      }
    },
    computed: {
      isFuture () {
        return dayjs(this.transaction.date).isAfter()
      },
      accountKey () {
        if (this.transaction.from.subject.__typename === 'Account' && this.transaction.from.subject.id === this.accountId) {
          return 'from'
        }
        if (this.transaction.to.subject.__typename === 'Account' && this.transaction.to.subject.id === this.accountId) {
          return 'to'
        }
        return undefined
      },
      payee () {
        return this.transaction[this.accountKey === 'to' ? 'from' : 'to'].subject
      },
      accountSubject () {
        return this.transaction[this.accountKey]
      },
      categories () {
        return this.transaction.categories.filter(c => c.category).map(c => c.category.name).join(', ')
      },
      amount () {
        if (this.accountKey === 'from') {
          return this.transaction.amount * -1
        }
        return this.transaction.amount
      }
    }
  }
</script>
