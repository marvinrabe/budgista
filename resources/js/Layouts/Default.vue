<template>
  <div class="h-full">
    <div class="container">
      <div class="flex items-start">
        <AppSidebar/>
        <div class="flex-1 min-w-0 p-4 md:px-8">
          <div class="bg-yellow-0 border-yellow-3 border rounded p-3 mb-4">
    <div class="md:flex items-center text-black-75">
          <strong>Budgista will shut down on 31.12.2021. Thank you for your trust. Please look for a different budgeting solution. If you need a copy of your data, please get in touch: marvin.rabe@gmail.com</strong>
    </div>
  </div>


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
