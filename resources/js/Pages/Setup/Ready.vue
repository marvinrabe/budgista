<template>
  <Layout :step="4" :title="$t('title.setupReady')" @next="next">
    <p class="mb-4">{{ $t('message.setupReady')}}</p>
    <p>{{ $t('message.setupContact')}}</p>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Setup'

  export default {
    components: {
      Layout
    },
    methods: {
      next () {
        this.$inertia.visit('/budget')
      }
    }
  }
</script>
