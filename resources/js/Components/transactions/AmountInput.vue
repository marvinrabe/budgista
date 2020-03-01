<template>
  <AppMoneyInput
    :value="absValue"
    @input="setInput"
    ref="amount"
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
    computed: {
      absValue () {
        return Math.abs(this.value)
      }
    },
    watch: {
      type () {
        this.setInput(this.absValue)
      }
    },
    methods: {
      setInput (result) {
        this.$emit('input', this.type * result)
      }
    }
  }
</script>
