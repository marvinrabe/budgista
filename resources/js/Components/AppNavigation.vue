<template>
  <nav
    class="border-t md:border-t-0 md:border-b border-gray-3 fixed bottom-0 md:bottom-auto md:top-0 bg-white w-full z-10">
    <div class="container p-1 md:px-4 md:py-2 flex items-center">
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
          <inertia-link
            href="/transactions/create"
            :title="$t('action.create.transaction')"
            class="text-white hover:text-white flex items-center justify-center text-xl shadow-lg rounded-full w-10 h-10 bg-blue-6 hover:bg-blue-7 mx-2 md:hidden">
            <PlusIcon/>
          </inertia-link>
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

      <div class="ml-auto hidden md:flex items-center">
        <AppButton
          :title="$t('action.create.transaction')"
          to="/transactions/create"
          variant="primary"
        >
          <PlusIcon/>
          {{ $t('word.transaction') }}
        </AppButton>
        <inertia-link
          class="ml-2 text-gray-6 hover:text-gray-8"
          href="/settings"
          :title="$t('title.settings')"
        >
          <CogIcon/>
        </inertia-link>
      </div>
    </div>
  </nav>
</template>

<script>
  import AppLogo from './AppLogo'
  import AppNavigationItem from '@/Components/AppNavigationItem'
  import { faEnvelope, faUniversity, faChartBar, faCog, faPlus } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '@/Utils/Icons'
  import FormGroup from '@/Components/form/FormGroup'
  import AppButton from '@/Components/form/AppButton'

  export default {
    components: {
      AppButton,
      AppNavigationItem,
      AppLogo,
      CogIcon: iconComponent({ icon: faCog, fixedWidth: true }),
      PlusIcon: iconComponent({ icon: faPlus }),
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
