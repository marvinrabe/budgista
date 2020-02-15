<template>
  <nav class="shadow-md px-4 py-2 fixed top-0 bg-white w-full z-10">
    <div class="w-full flex items-center justify-between">
      <AppLogo
        class="navbar-brand"
        style="height: 40px;"
        :height="40"
      />

      <TheUserMenu class="hidden lg:block ml-auto"/>

      <AppSidebarToggle class="lg:hidden"/>
    </div>
  </nav>
</template>

<script>
  import AppLogo from './AppLogo'
  import AppSidebarToggle from './AppSidebarToggle'
  import TheUserMenu from './TheUserMenu'

  export default {
    components: {
      AppLogo,
      AppSidebarToggle,
      TheUserMenu
    }
  }
</script>
