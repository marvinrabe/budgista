<template>
  <nav class="shadow-sm fixed top-0 bg-white w-full z-10">
    <div class="container px-4 py-2 flex items-center justify-between">
      <AppSidebarToggle class="lg:hidden"/>

      <AppLogo
        class="navbar-brand mr-auto lg:ml-4"
        style="height: 40px;"
        :height="40"
      />

      <TheUserMenu class="hidden lg:block"/>
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
