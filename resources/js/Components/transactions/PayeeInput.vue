<template>
    <input
      :value="value"
      @input="e => $emit('input', e.target.value)"
      class="form-control"
      type="text"
    >
</template>

<script>

  export default {
    props: {
      value: {
        type: String,
        default: ''
      }
    }
  }
</script>
