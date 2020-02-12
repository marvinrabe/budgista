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
          return this.value >= 0 ? 'text-green-7' : 'text-red-7'
        }
        return ''
      },
      text () {
        return formatter.format(this.value)
      }
    }
  }
</script>
