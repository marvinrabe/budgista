<template>
  <div class="numeric">
    <AppMoney
      :value="value"
      :color="color"
      class="numeric__value"
    />
    <p class="numeric__label">
      {{ label }}
    </p>
  </div>
</template>

<script>
  import AppMoney from '@/Components/AppMoney'

  export default {
    components: { AppMoney },
    props: {
      value: Number,
      label: String,
      color: Boolean,
    }
  }
</script>
