<template>
  <div class="h-full" style="padding-top: 56px;">
    <AppHeader/>

    <AppSidebar/>

    <div class="container-fluid py-3" id="content">
      <verify-alert/>

      <slot></slot>
    </div>
  </div>
</template>

<script>
  import AppHeader from '@/Components/AppHeader'
  import AppSidebar from '@/Components/AppSidebar'
  import VerifyAlert from '@/Components/profile/TheVerifyAlert'

  export default {
    components: {
      AppHeader,
      AppSidebar,
      VerifyAlert
    }
  }
</script>
