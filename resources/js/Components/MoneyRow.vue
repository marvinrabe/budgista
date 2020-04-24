<template>
  <div class="py-1 flex items-baseline justify-between">
    <div class="label mr-6">
      <slot name="label">
        {{ label }}
      </slot>
    </div>

    <AppMoney :value="value" :color="color" class="text-sm"/>
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
