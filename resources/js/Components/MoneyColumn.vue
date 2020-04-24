<template>
  <div class="flex flex-col">
    <span class="label whitespace-no-wrap">
      {{ label }}
    </span>
    <AppMoney
      :value="value"
      :color="color"
      class="flex-1 whitespace-no-wrap text-xl"
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
