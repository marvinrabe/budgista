<template>
  <Layout>
    <AppToolbar :title="$t('title.profile')"/>

    <div class="card mb-3">
      <div class="card-body">
        <SettingsEmail/>
      </div>

      <div class="card-body border-t border-gray-3">
        <SettingsPassword/>
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
  import AppToolbar from '@/Components/AppToolbar'
  import AppButton from '@/Components/form/AppButton'
  import SettingsEmail from '@/Components/profile/SettingsEmail.vue'
  import SettingsPassword from '@/Components/profile/SettingsPassword.vue'

  export default {
    components: {
      Layout,
      AppButton,
      AppToolbar,
      SettingsEmail,
      SettingsPassword
    },
    metaInfo () {
      return {
        title: this.$t('title.profile')
      }
    }
  }
</script>
