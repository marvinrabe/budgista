<template>
  <Layout :title="$t('title.statistics')">
    <template v-slot:menu>
      <h2 class="text-xl text-gray-8 mb-4 px-4">
        {{ $t('title.statistics') }}
      </h2>

      <AppMenu>
        <AppMenuItem
          :label="$t('title.statisticNetWorth')"
          href="/statistics/netWorth"/>
        <AppMenuItem
          :label="$t('title.statisticIncomeVsExpense')"
          href="/statistics/incomeVsExpense"/>
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
        this.$inertia.visit('/statistics/netWorth', { replace: true })
      }
    },
  }
</script>
