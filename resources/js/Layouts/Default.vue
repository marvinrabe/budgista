<template>
  <div class="h-full">
    <AppNavigation/>

    <div class="container px-4 lg:px-6 pt-4 pb-24 md:pt-20 md:pb-6">
      <VerifyAlert/>

      <slot name="container">
        <AppContainer>
          <template v-slot:menu>
            <slot name="menu"/>
          </template>

          <template v-slot:content>
            <slot/>
          </template>
        </AppContainer>
      </slot>
    </div>
  </div>
</template>

<script>
  import AppNavigation from '@/Components/AppNavigation'
  import VerifyAlert from '@/Components/profile/TheVerifyAlert'
  import base from '@/Layouts/base'
  import AppContainer from '@/Components/AppContainer'

  export default {
    components: {
      AppContainer,
      AppNavigation,
      VerifyAlert
    },
    mixins: [base]
  }
</script>
