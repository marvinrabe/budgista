<template>
  <input
    class="form-control"
    type="date"
    :value="value"
    @input="e => this.$emit('input', e.target.value)"
  />
</template>

<script>
  export default {
    props: {
      value: String
    }
  }
</script>
