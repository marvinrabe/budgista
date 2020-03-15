<template>
  <div class="my-1 rounded-full bg-gray-3 h-1">
    <div class="h-full  rounded-full" :style="{width}" :class="color"></div>
  </div>
</template>

<script>
  export default {
    props: {
      budget: Number,
      activity: Number,
      available: Number
    },
    computed: {
      percentage () {
        if (this.budget === 0 && this.available < 0) {
          return 1
        }

        if (this.budget === 0) {
          return 0
        }

        if (this.activity > 0) {
          return 0
        }

        return -this.activity / this.budget
      },
      width () {
        return this.percentage > 1 ? '100%' : (this.percentage * 100 + '%')
      },
      color () {
        if (this.available < 0) {
          return 'bg-red-9'
        } else if (this.percentage === 1 || this.available === 0) {
          return 'bg-gray-6'
        } else if (this.available >= 0 && this.percentage >= 1) {
          return 'bg-yellow-7' // based on date
        } else if (this.percentage >= 1) {
          return 'bg-red-9'
        }
        return 'bg-green-9'
      }
    }
  }
</script>
