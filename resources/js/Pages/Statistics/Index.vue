<template>
  <Layout :title="$t('title.statistics')" redirect="/statistics/netWorth">
    <template v-slot:menu>
      <h2 class="text-xl mb-4 px-4">
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
