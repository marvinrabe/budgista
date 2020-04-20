<template>
  <div class="h-full">
    <div class="container">
      <div class="flex items-start">
        <AppSidebar/>
        <div class="flex-1 min-w-0 p-4">
          <VerifyAlert/>

          <div class="flex flex-wrap items-center mb-4 min-h-10">
            <AppSidebarToggle class="-ml-2 lg:hidden"/>
            <slot name="header">
              <h2 class="text-xl">
                {{ title }}
              </h2>
            </slot>
          </div>

          <slot/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import AppNavigation from '@/Components/AppNavigation'
  import VerifyAlert from '@/Components/profile/TheVerifyAlert'
  import base from '@/Layouts/base'
  import AppSidebarToggle from '@/Components/AppSidebarToggle'
  import AppSidebar from '@/Components/AppSidebar'

  export default {
    components: {
      AppSidebar,
      AppSidebarToggle,
      AppNavigation,
      VerifyAlert
    },
    mixins: [base],
  }
</script>
