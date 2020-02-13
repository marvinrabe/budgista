<template>
  <nav class="navbar navbar-light shadow-sm fixed top-0 bg-white w-full z-10">
    <div class="w-full flex items-center justify-around">
      <div class="lg:hidden mr-auto">
        <AppSidebarToggle/>
      </div>

      <AppLogo
        class="navbar-brand"
        style="height: 40px;"
        :height="40"
      />

      <ul class="nav ml-auto">
        <li class="nav-item dropdown d-none d-md-block">
          <TheUserMenu/>
        </li>
      </ul>
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
