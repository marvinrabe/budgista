<template>
  <nav class="border-b border-gray-3 fixed top-0 bg-white w-full z-10">
    <div class="container px-4 py-2 flex items-center justify-center lg:justify-between">
      <AppSidebarToggle class="lg:hidden mr-auto"/>

      <AppLogo
        class="navbar-brand mr-auto lg:ml-4"
        style="height: 40px;"
        :height="40"
      />

      <TheUserMenu class="hidden lg:block"/>
      <div class="lg:hidden" style="width: 60px">&nbsp;</div>
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
