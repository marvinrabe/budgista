<template>
  <TransactionListEmpty v-if="isEmpty"/>
  <div v-else>
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

    <TransactionListItem
      :key="transaction.id"
      :transaction="transaction"
      v-for="transaction of transactions"
    />
  </div>
</template>

<script>
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
    computed: {
      isEmpty () {
        return this.transactions.length === 0
      }
    }
  }
</script>
