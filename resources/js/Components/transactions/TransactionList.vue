<template>
  <TransactionListEmpty v-if="isEmpty"/>
  <div class="card" v-else>
    <div class="card-header p-0 hidden sm:flex">
      <div class="transaction-item">
        &nbsp;
        <div class="transaction-date">
          {{ $t('form.date') }}
        </div>
        <div class="transaction-payee">
          {{ $t('form.payee') }}
        </div>
        <div class="transaction-category">
          {{ $t('form.category') }}
        </div>
        <div class="transaction-amount">
          {{ $t('form.amount') }}
        </div>
      </div>
      <div class="transaction-clear">
        &nbsp;
      </div>
    </div>

    <div
      class="text-center p-1 border-b border-gray-3 bg-blue-0"
      v-if="countFutureTransactions > 0 && !showFutureTransactions"
    >
      <a
        @click.prevent="showFutureTransactions = true"
        class="text-sm text-blue-9"
        href="#"
      >
        {{ $tc('action.futureTransactions', countFutureTransactions, { count: countFutureTransactions }) }}
      </a>
    </div>
    <TransactionListItem
      :key="transaction.id"
      :transaction="transaction"
      v-for="transaction of filteredTransactions"
    />
  </div>
</template>

<script>
  import dayjs from 'dayjs'
  import TransactionListEmpty from './TransactionListEmpty'
  import TransactionListItem from './TransactionListItem'

  export default {
    components: {
      TransactionListEmpty,
      TransactionListItem
    },
    props: {
      transactions: {
        type: Array,
        required: true
      }
    },
    data () {
      return {
        showFutureTransactions: false
      }
    },
    computed: {
      isEmpty () {
        return this.transactions.length === 0
      },
      filteredTransactions () {
        if (this.showFutureTransactions) {
          return this.transactions
        }
        return this.transactions.filter(x => !dayjs(x.date).isAfter())
      },
      countFutureTransactions () {
        return this.transactions.filter(x => dayjs(x.date).isAfter()).length
      }
    }
  }
</script>
