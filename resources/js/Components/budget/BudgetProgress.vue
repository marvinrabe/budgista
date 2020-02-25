<template>
  <div class="my-1 rounded-full bg-gray-1 h-1">
    <div class="h-full  rounded-full" :style="{width}" :class="color"></div>
  </div>
</template>

<script>
  export default {
    props: {
      activity: Number,
      total: Number
    },
    computed: {
      percentage () {
        if (this.total === 0) {
          return 0
        }

        return this.activity / this.total
      },
      width () {
        return this.percentage > 1 ? '100%' : (this.percentage * 100 + '%')
      },
      color () {
        if (this.percentage === 1) {
          return 'bg-gray-3'
        } else if (this.percentage >= 1) {
          return 'bg-red-9'
        }
        return 'bg-green-9'
      }
    }
  }
</script>
