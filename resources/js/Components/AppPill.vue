<template>
  <inertia-link
    class="pill"
    :href="href"
    :class="{'pill--active': active}"
  >
    {{ label }}
  </inertia-link>
</template>

<script>
  export default {
    props: {
      label: String,
      href: String
    }
  }
</script>
