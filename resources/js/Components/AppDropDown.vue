<template>
  <details class="dropdown">
    <summary>
      <slot name="activator" />
    </summary>
    <div class="dropdown__body -mx-2" :class="bodyClass">
      <slot />
    </div>
  </details>
</template>

<script>
  export default {
    props: {
      bodyClass: {
        type: String,
        default: undefined
      }
    }
  }
</script>
