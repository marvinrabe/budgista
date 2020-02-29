<template>
  <Layout :title="$t('title.settings')" redirect="/profile">
    <template v-slot:menu>
      <h2 class="text-xl mb-4 px-4">
        {{ $t('title.settings') }}
      </h2>

      <AppMenu>
        <AppMenuItem
          :label="$t('title.profile')"
          href="/profile"/>
        <AppMenuItem
          :label="$t('title.general')"
          href="/settings/edit"/>
        <AppMenuItem
          :label="$t('title.categories')"
          href="/categories"/>
      </AppMenu>
    </template>

    <slot/>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Container'
  import AppMenu from '@/Components/AppMenu'
  import AppMenuItem from '@/Components/AppMenuItem'

  export default {
    components: {
      AppMenu,
      AppMenuItem,
      Layout,
    }
  }
</script>
