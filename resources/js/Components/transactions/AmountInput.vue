<template>
  <AppMoneyInput
    @input="input"
    ref="amount"
    v-model="amount"
  />
</template>

<script>
  import AppMoneyInput from '@/Components/form/AppMoneyInput'

  export default {
    components: {
      AppMoneyInput
    },
    props: {
      value: Number,
      type: Number
    },
    data () {
      return {
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
      }
    }
  }
</script>
