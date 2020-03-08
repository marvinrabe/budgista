<template>
  <textarea
    :value="value"
    class="form-control"
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
