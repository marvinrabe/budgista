<template>
  <textarea
    :value="value"
    class="form-input"
    @input="e => $emit('input', e.target.value)"></textarea>
</template>

<script>
  import autosize from 'autosize'

  export default {
    props: {
      value: {
        type: String,
        default: null
      }
    },
    mounted () {
      autosize(this.$el)
    }
  }
</script>
