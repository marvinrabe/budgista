<template>
  <div class="card">
    <TransactionListEmpty v-if="isEmpty"/>
    <div v-else>
      <TransactionListItem
        :key="transaction.id"
        :column="column"
        :transaction="transaction"
        v-for="transaction of transactions"
        :with-state="withState"
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
      column: String,
      withState: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      isEmpty () {
        return this.transactions.length === 0
      }
    }
  }
</script>
