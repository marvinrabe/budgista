<template>
  <div class="h-full" style="padding-top: 56px;">
    <AppHeader/>

    <div class="container container p-4 flex flex-no-wrap" id="content">
      <AppSidebar class="lg:w-1/3 xl:w-1/4"/>

      <main class="w-full lg:w-2/3 xl:w-3/4">
        <VerifyAlert/>

        <div class="flex items-center flex-wrap justify-between mb-4">
          <slot name="title">
            <h1 class="lg:order-first text-2xl ellipsis">
              {{ title }}
            </h1>
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
</template>

<script>
  import AppHeader from '@/Components/AppHeader'
  import AppSidebar from '@/Components/AppSidebar'
  import VerifyAlert from '@/Components/profile/TheVerifyAlert'

  export default {
    components: {
      AppHeader,
      AppSidebar,
      VerifyAlert
    },
    props: {
      title: String
    },
    metaInfo () {
      return {
        title: this.title
      }
    }
  }
</script>
