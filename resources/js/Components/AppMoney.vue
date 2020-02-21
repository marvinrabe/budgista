<template>
  <span
    :class="colorClass"
    class="font-numeric"
    v-text="text"
  />
</template>

<script>
  import { mixin as moneyMixin } from '@/Utils/Money'

  export default {
    mixins: [moneyMixin],
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
          return this.value >= 0 ? 'text-green-9' : 'text-red-9'
        }
        return ''
      },
      text () {
        return this.moneyFormat.format(this.value)
      }
    }
  }
</script>
