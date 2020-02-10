<template>
  <div id="wrapper">
    <div id="layout">
      <AppHeader/>

      <AppSidebar/>

      <div class="container-fluid py-3" id="content">
        <verify-alert/>

        <ZoomCenterTransition :duration="250" mode="out-in">
          <router-view :key="$route.fullPath"/>
        </ZoomCenterTransition>
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
  import ZoomCenterTransition from '@/Components/transition/ZoomCenterTransition'

  export default {
    components: {
      AppHeader,
      AppSidebar,
      VerifyAlert,
      ZoomCenterTransition
    }
  }
</script>
