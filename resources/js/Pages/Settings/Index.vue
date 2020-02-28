<template>
  <Layout :title="$t('title.settings')">
    <template v-slot:menu>
      <h2 class="text-xl text-gray-8 mb-4 px-4">
        {{ $t('title.settings') }}
      </h2>

      <AppMenu>
        <AppMenuItem
          :label="$t('title.profile')"
          href="/settings/profile"/>
        <AppMenuItem
          :label="$t('title.general')"
          href="/settings/edit"/>
      </AppMenu>
    </template>

    <slot/>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppMenu from '@/Components/AppMenu'
  import AppMenuItem from '@/Components/AppMenuItem'

  export default {
    components: {
      AppMenu,
      AppMenuItem,
      Layout,
    },
    mounted () {
      if (window.innerWidth >= 768 && !this.$slots.default) {
        this.$inertia.visit('/settings/profile', { replace: true })
      }
    },
  }
</script>
