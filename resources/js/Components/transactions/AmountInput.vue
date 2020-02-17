<template>
  <div class="flex items-stretch">
    <div class="border border-r-0 border-gray-4 flex items-center rounded-l">
      <b-dropdown
        :text="(type === 1) ? $t('form.income') : $t('form.expense')"
        :toggle-class="'py-1 ' + ((type === 1) ? 'text-green-8 hover:text-green-9':'text-red-8 hover:text-red-9')"
      >
        <b-dropdown-item @click="setToExpense">
          {{ $t('form.expense') }}
        </b-dropdown-item>
        <b-dropdown-item @click="setToIncome">
          {{ $t('form.income') }}
        </b-dropdown-item>
      </b-dropdown>
    </div>

    <app-money-input
      @input="input"
      ref="amount"
      class="rounded-l-none"
      v-bind="$attrs"
      v-model="amount"
    />
  </div>
</template>

<script>
  import AppMoneyInput from '../form/AppMoneyInput'

  const EXPENSE = -1
  const INCOME = 1

  export default {
    inheritAttrs: false,
    components: {
      AppMoneyInput
    },
    props: ['value'],
    data () {
      return {
        type: this.value <= 0 ? EXPENSE : INCOME,
        amount: Math.abs(this.value)
      }
    },
    watch: {
      value () {
        this.amount = Math.abs(this.value)
      }
    },
    methods: {
      input () {
        this.$emit('input', this.type * this.amount)
      },
      setToExpense () {
        this.type = EXPENSE
        this.input()
      },
      setToIncome () {
        this.type = INCOME
        this.input()
      }
    }
  }
</script>
