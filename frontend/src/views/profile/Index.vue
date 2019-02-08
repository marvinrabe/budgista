<template>
    <div class="main">
        <AppToolbar :title="$t('title.profile')"/>

        <div class="card mb-3">
            <div class="card-body">
                <settings-email/>
            </div>

            <div class="card-body border-top">
                <settings-password/>
            </div>
        </div>

        <div class="text-right">
            <router-link :to="{name: 'leave'}"
                         class="btn btn-text-dark"
                         v-t="'title.deleteUser'">
            </router-link>
        </div>

    </div>
</template>

<script>
    import AppToolbar from '../../components/AppToolbar'
    import SettingsEmail from '../../components/profile/SettingsEmail.vue'
    import SettingsPassword from '../../components/profile/SettingsPassword.vue'

    export default {
        components: {
            AppToolbar,
            SettingsEmail,
            SettingsPassword
        }
    }
</script>
