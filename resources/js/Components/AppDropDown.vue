<template>
  <details class="dropdown">
    <summary>
      <slot name="activator" />
    </summary>
    <div class="dropdown__body -mx-1" :class="bodyClass">
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
