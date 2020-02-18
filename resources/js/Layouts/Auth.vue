<template>
  <div class="p-4 w-full flex flex-col items-center flex-no-wrap">
    <inertia-link href="/login">
      <AppLogo
        :height="48"
        class="mb-4 flex-shrink-0"
      />
    </inertia-link>

    <div class="w-full lg:w-5/12 lg:w-6/12 xl:w-4/12">
      <slot></slot>
    </div>
  </div>
</template>

<script>
  import AppLogo from '@/Components/AppLogo.vue'
  import base from '@/Layouts/base'

  export default {
    components: {
      AppLogo
    },
    mixins: [base]
  }
</script>
