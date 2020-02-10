<template>
  <nav class="navbar navbar-light fixed-top bg-white">
    <div class="container-fluid">
      <div class="d-lg-none mr-auto">
        <AppSidebarToggle />
      </div>

      <AppLogo
        class="navbar-brand"
        :height="40"
      />

      <ul class="nav ml-auto">
        <li class="nav-item dropdown d-none d-md-block">
          <TheUserMenu />
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
