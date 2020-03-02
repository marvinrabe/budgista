<template>
  <div class="my-1 rounded-full bg-gray-3 h-1">
    <div class="h-full  rounded-full" :style="{width}" :class="color"></div>
  </div>
</template>

<script>
  export default {
    props: {
      category: Object
    },
    computed: {
      percentage () {
        if (this.category.budget === 0) {
          return 0
        }

        if (this.category.activity > 0) {
          return 0
        }

        return -this.category.activity / this.category.budget
      },
      width () {
        return this.percentage > 1 ? '100%' : (this.percentage * 100 + '%')
      },
      color () {
        if (this.category.available < 0) {
          return 'bg-red-9'
        } else if (this.percentage === 1 || this.category.available === 0) {
          return 'bg-gray-6'
        } else if (this.category.available >= 0 && this.percentage >= 1) {
          return 'bg-yellow-7' // based on date
        } else if (this.percentage >= 1) {
          return 'bg-red-9'
        }
        return 'bg-green-9'
      }
    }
  }
</script>
