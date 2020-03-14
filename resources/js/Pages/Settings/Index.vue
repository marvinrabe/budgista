<template>
  <Layout :title="$t('title.settings')" redirect="/profile">
    <template v-slot:menu>
      <AppMenu>
        <AppMenuItem
          :label="$t('title.profile')"
          :icon="icons.profile"
          href="/profile"/>
        <AppMenuItem
          :label="$t('title.general')"
          :icon="icons.general"
          href="/settings/edit"/>
        <AppMenuItem
          :label="$t('title.categories')"
          :icon="icons.categories"
          href="/categories"/>
      </AppMenu>

      <div class="py-2 flex justify-center">
        <button
          class="pill"
          @click="logout">
          {{ $t('action.logout') }}
        </button>
      </div>
    </template>

    <slot/>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Container'
  import AppMenu from '@/Components/AppMenu'
  import AppMenuItem from '@/Components/AppMenuItem'
  import { clearCache } from '@/Utils/ServiceWorker'
  import { faUserCircle, faInbox, faCog } from '@fortawesome/free-solid-svg-icons'

  export default {
    components: {
      AppMenu,
      AppMenuItem,
      Layout,
    },
    props: {
      title: {
        type: String,
        default: null
      }
    },
    data() {
      return {
        icons: {
          profile: faUserCircle,
          general: faCog,
          categories: faInbox
        }
      }
    },
    methods: {
      logout () {
        this.$inertia
          .post('/logout')
          .then(() => clearCache())
      },
    }
  }
</script>
