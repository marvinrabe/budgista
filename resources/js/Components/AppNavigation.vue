<template>
  <nav class="border-t md:border-t-0 md:border-b border-gray-3 fixed bottom-0 md:bottom-auto md:top-0 bg-white w-full z-10">
    <div class="container px-4 py-2 flex items-center">
      <AppLogo
        class="hidden md:block md:ml-4"
        style="height: 40px;"
        :height="40"
      />

      <nav class="w-full md:w-auto md:ml-2">
        <ul class="flex">
          <AppNavigationItem
            :label="$t('title.budget')"
            :icon="icons.budget"
            href="/budget"
          />
          <AppNavigationItem
            :label="$t('title.accounts')"
            :icon="icons.transactions"
            href="/accounts"
          />
          <AppNavigationItem
            :label="$t('title.statistics')"
            :icon="icons.statistics"
            href="/statistics"
          />
        </ul>
      </nav>

      <TheUserMenu class="ml-auto hidden lg:block"/>
    </div>
  </nav>
</template>

<script>
  import AppLogo from './AppLogo'
  import TheUserMenu from './TheUserMenu'
  import AppNavigationItem from '@/Components/AppNavigationItem'
  import { faEnvelope, faUniversity, faChartBar } from '@fortawesome/free-solid-svg-icons'

  export default {
    components: {
      AppNavigationItem,
      AppLogo,
      TheUserMenu
    },
    data() {
      return {
        icons: {
          budget: faEnvelope,
          transactions: faUniversity,
          statistics: faChartBar
        }
      }
    }
  }
</script>
