<template>
  <img
    src="../Assets/logo.svg"
    alt="Budgista"
    :height="height"
  >
</template>

<script>
  export default {
    props: {
      height: {
        type: Number,
        default: 48
      }
    }
  }
</script>
