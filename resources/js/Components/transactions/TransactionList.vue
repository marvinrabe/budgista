<template>
  <div>
    <div class="transactions-header">
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

    <FadeTransition :duration="250" mode="out-in">
      <TransactionListSkeleton v-if="loading"/>
      <TransactionListEmpty v-else-if="isEmpty"/>
      <div class="card" v-else>
        <div
          class="text-center p-1 transactions-row-dummy"
          v-if="countFutureTransactions > 0 && !showFutureTransactions"
        >
          <a
            @click.prevent="showFutureTransactions = true"
            class="small"
            href="#"
          >
            {{ $tc('action.futureTransactions', countFutureTransactions, { count: countFutureTransactions }) }}
          </a>
        </div>
        <TransactionListItem
          :account-id="accountId"
          :key="transaction.id"
          :transaction="transaction"
          v-for="transaction of filteredTransactions"
        />
      </div>
    </FadeTransition>
  </div>
</template>

<script>
  import dayjs from 'dayjs'
  import FadeTransition from 'vue2-transitions/src/Fade/FadeTransition'
  import TransactionListEmpty from './TransactionListEmpty'
  import TransactionListItem from './TransactionListItem'
  import TransactionListSkeleton from './TransactionListSkeleton'

  export default {
    components: {
      FadeTransition,
      TransactionListEmpty,
      TransactionListItem,
      TransactionListSkeleton
    },
    props: {
      transactions: {
        type: Array,
        required: true
      },
      loading: {
        type: Boolean,
        default: false
      },
      accountId: {
        type: String,
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
        return this.transactions.length === 0 && !this.loading
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
