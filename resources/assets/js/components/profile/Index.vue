<template>
    <div class="main">
        <app-toolbar :title="$t('title.profile')"/>

        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $t('title.updateEmail') }}</h5>

                <settings-email/>
            </div>

            <div class="card-body border-top">
                <h5>{{ $t('title.updatePassword') }}</h5>

                <settings-password/>
            </div>
        </div>

        <div class="text-right">
            <router-link class="btn btn-text-dark"
                         :to="{name: 'leave'}"
                         v-t="'title.deleteUser'">
            </router-link>
        </div>

    </div>
</template>

<script>
    import SettingsEmail from './SettingsEmail.vue'
    import SettingsPassword from './SettingsPassword.vue'

    export default {
        components: {
            SettingsEmail,
            SettingsPassword
        }
    }
</script>