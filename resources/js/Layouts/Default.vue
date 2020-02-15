<template>
  <div class="h-full" style="padding-top: 56px;">
    <AppHeader/>

    <AppSidebar/>

    <div class="container-fluid py-3" id="content">
      <VerifyAlert/>

      <div class="flex items-center flex-wrap justify-between mb-4">
        <slot name="title">
          <h1 class="lg:order-first text-2xl ellipsis">
            {{ title }}
          </h1>
        </slot>

        <div class="lg:order-last btn-group">
          <slot name="actions"/>
        </div>

        <slot name="header"/>
      </div>

      <slot></slot>
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
