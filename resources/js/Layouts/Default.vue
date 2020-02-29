<template>
  <div class="h-full">
    <AppNavigation/>

    <div class="container px-4 lg:px-6 pt-4 pb-24 md:pt-20 md:pb-6">
      <VerifyAlert/>

      <slot/>
    </div>
  </div>
</template>

<script>
  import AppNavigation from '@/Components/AppNavigation'
  import VerifyAlert from '@/Components/profile/TheVerifyAlert'
  import base from '@/Layouts/base'

  export default {
    components: {
      AppNavigation,
      VerifyAlert
    },
    mixins: [base]
  }
</script>
