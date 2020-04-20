<template>
    <input
      :value="value"
      @input="e => $emit('input', e.target.value)"
      class="form-input"
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
