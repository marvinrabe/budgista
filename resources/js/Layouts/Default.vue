<template>
  <div class="h-full" style="padding-top: 56px;">
    <AppHeader/>

    <div class="container p-4">
      <VerifyAlert/>

      <div class="flex flex-no-wrap">
        <AppSidebar class="lg:w-3/12 xl:w-1/4"/>

        <main class="w-full lg:w-9/12 xl:w-3/4">
          <div class="flex items-center flex-wrap justify-between mb-4">
            <slot name="title">
              <div class="ellipsis lg:order-first">
                <h1 class="text-gray-8 text-2xl">
                  {{ title }}
                </h1>
              </div>
            </slot>

            <div class="lg:order-last flex">
              <slot name="actions"/>
            </div>

            <slot name="header"/>
          </div>

          <slot></slot>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
  import AppHeader from '@/Components/AppHeader'
  import AppSidebar from '@/Components/AppSidebar'
  import VerifyAlert from '@/Components/profile/TheVerifyAlert'
  import base from '@/Layouts/base'

  export default {
    components: {
      AppHeader,
      AppSidebar,
      VerifyAlert
    },
    mixins: [base]
  }
</script>
