<template>
  <span
    :class="colorClass"
    class="money"
    v-text="text"
  />
</template>

<script>
  import moneyFormat from '../mixins/moneyFormat'

  export default {
    mixins: [moneyFormat],
    props: {
      value: Number,
      color: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      colorClass () {
        if (this.color) {
          return this.value >= 0 ? 'money--positive' : 'money--negative'
        }
        return ''
      },
      text () {
        return this.moneyFormat(this.value)
      }
    }
  }
</script>

<style scoped>
  .money {

  }

  .money--positive {
    @apply text-green-dark;
  }

  .money--negative {
    @apply text-red-dark;
  }
</style>
