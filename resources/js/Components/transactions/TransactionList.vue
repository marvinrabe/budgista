<template>
  <div class="card">
    <TransactionListEmpty v-if="isEmpty"/>
    <div v-else>
      <TransactionListItem
        :key="transaction.id"
        :column="column"
        :transaction="transaction"
        v-for="transaction of transactions"
      />
    </div>
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
      transactions: Array,
      column: String
    },
    computed: {
      isEmpty () {
        return this.transactions.length === 0
      }
    }
  }
</script>
