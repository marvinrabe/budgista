<template>
  <span
    :class="colorClass"
    class="money"
    v-text="text"
  />
</template>

<script>
  import { formatter } from '@/helpers'

  export default {
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
        return formatter.format(this.value)
      }
    }
  }
</script>

<style scoped>
  .money {

  }

  .money--positive {
    @apply text-green-700;
  }

  .money--negative {
    @apply text-red-700;
  }
</style>
