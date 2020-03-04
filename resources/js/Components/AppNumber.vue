<template>
  <div class="numeric">
    <span class="label">
      {{ label }}
    </span>
    <AppMoney
      :value="value"
      :color="color"
      class="numeric__value text-xl"
    />
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
