<template>
  <div>
    <input
      :value="value"
      @input="e => $emit('input', e.target.value)"
      class="form-control"
      type="text"
      v-bind="$attrs"
      v-validate="'required'"
    >
  </div>
</template>

<script>

  export default {
    inheritAttrs: false,
    inject: ['$validator'],
    props: {
      value: {
        type: String,
        default: ''
      }
    }
  }
</script>
