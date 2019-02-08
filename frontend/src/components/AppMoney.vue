<template>
    <span v-text="formattedValue"></span>
</template>

<script>
  export default {
    props: ['value'],
    computed: {
      formattedValue: function () {
        return this.$moneyFormatter().format(this.value);
      }
    }
  }
</script>
