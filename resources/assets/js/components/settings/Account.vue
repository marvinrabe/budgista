<template>
    <div class="my-3">
        <settings-email/>
        <div class="w-100"></div>
        <settings-password/>
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