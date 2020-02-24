<template>
  <Layout :title="$t('title.profile')">
    <div class="card">
      <div class="card-body">
        <SettingsEmail/>
      </div>

      <div class="card-body border-t border-gray-3">
        <SettingsPassword/>
      </div>

      <div class="card-body border-t border-gray-3">
        <SettingsGoogle/>
      </div>
    </div>

    <div class="text-right">
      <AppButton
        :label="$t('title.deleteUser')"
        to="/profile/terminate"
        subtle
      />
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import AppButton from '@/Components/form/AppButton'
  import SettingsEmail from '@/Components/profile/SettingsEmail.vue'
  import SettingsGoogle from '@/Components/profile/SettingsGoogle.vue'
  import SettingsPassword from '@/Components/profile/SettingsPassword.vue'

  export default {
    components: {
      Layout,
      AppButton,
      SettingsEmail,
      SettingsGoogle,
      SettingsPassword
    }
  }
</script>
