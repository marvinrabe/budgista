<template>
  <span
    v-if="visible"
    class="invalid-feedback"
  >
    {{ message }}
  </span>
</template>

<script>
  export default {
    props: {
      name: {
        type: String
      }
    },
    computed: {
      visible () {
        return this.name in this.$page.errors
      },
      message () {
        return this.$page.errors[this.name][0]
      }
    }
  }
</script>

<style>
    /* Invalid Feedback is always displayed as block, because we use vue to hide message if there is no error. */
    .invalid-feedback {
        display: block;
    }
</style>
