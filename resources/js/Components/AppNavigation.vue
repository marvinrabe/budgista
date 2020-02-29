<template>
  <nav
    class="border-t md:border-t-0 md:border-b border-gray-3 fixed bottom-0 md:bottom-auto md:top-0 bg-white w-full z-10">
    <div class="container px-1 md:px-4 py-2 flex items-center">
      <AppLogo
        class="hidden md:block"
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
          <AppNavigationItem
            :label="$t('title.settings')"
            :icon="icons.settings"
            href="/settings"
            class="md:hidden"
          />
        </ul>
      </nav>

      <inertia-link
        class="ml-auto hidden md:block text-gray-6 hover:text-gray-8"
        href="/settings"
        :title="$t('title.settings')"
      >
        <CogIcon/>
      </inertia-link>
    </div>
  </nav>
</template>

<script>
  import AppLogo from './AppLogo'
  import AppNavigationItem from '@/Components/AppNavigationItem'
  import { faEnvelope, faUniversity, faChartBar, faCog } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '@/Utils/Icons'

  export default {
    components: {
      AppNavigationItem,
      AppLogo,
      CogIcon: iconComponent({ icon: faCog, fixedWidth: true }),
    },
    data () {
      return {
        icons: {
          budget: faEnvelope,
          transactions: faUniversity,
          statistics: faChartBar,
          settings: faCog
        }
      }
    }
  }
</script>
