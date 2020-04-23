<template>
  <Layout :title="$t('title.profile')">
    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">{{ $t('title.profile')}}</h2>
      </div>

      <div class="card-body">
        <SettingsProfile/>
      </div>

      <div class="card-body border-t border-gray-3">
        <SettingsEmail/>
      </div>

      <div class="card-body border-t border-gray-3">
        <SettingsGoogle/>
      </div>
    </div>

    <div class="text-right">
      <AppButton
        class="hover:text-red-9"
        :label="$t('title.deleteUser')"
        to="/profile/terminate"
        subtle
      />
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Pages/Settings/Index'
  import AppButton from '@/Components/form/AppButton'
  import SettingsEmail from '@/Components/profile/SettingsEmail.vue'
  import SettingsGoogle from '@/Components/profile/SettingsGoogle.vue'
  import SettingsPassword from '@/Components/profile/SettingsPassword.vue'
  import SettingsProfile from '@/Components/profile/SettingsProfile'

  export default {
    components: {
      SettingsProfile,
      Layout,
      AppButton,
      SettingsEmail,
      SettingsGoogle
    }
  }
</script>
