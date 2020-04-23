<template>
  <Layout :title="$t('security.title')">
    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">{{ $t('security.title')}}</h2>
      </div>
      <div class="card-body border-t border-gray-3">
        <SettingsPassword/>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Pages/Settings/Index'
  import AppButton from '@/Components/form/AppButton'
  import SettingsPassword from '@/Components/profile/SettingsPassword.vue'

  export default {
    components: {
      Layout,
      AppButton,
      SettingsPassword
    }
  }
</script>
