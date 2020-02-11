<template>
  <div id="wrapper">
    <div id="layout">
      <AppHeader/>

      <AppSidebar/>

      <div class="container-fluid py-3" id="content">
        <verify-alert/>

        <slot></slot>
      </div>
    </div>
  </div>
</template>

<style scoped>
  #wrapper, #layout {
    height: 100%;
  }

  #layout {
    padding-top: 56px;
  }
</style>

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
