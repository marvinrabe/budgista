<template>
    <div class="main">
        <app-toolbar :title="$t('title.profile')"/>

        <div class="mb-3">
            <h5>{{ $t('title.updateEmail') }}</h5>

            <div class="card mb-3">
                <div class="card-body">
                    <settings-email/>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <h5>{{ $t('title.updatePassword') }}</h5>

            <div class="card  mb-3">
                <div class="card-body">
                    <settings-password/>
                </div>
            </div>
        </div>

        <div class="text-right">
            <button class="btn btn-text-dark d-none" v-t="'action.deleteUserAccount'"></button>
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