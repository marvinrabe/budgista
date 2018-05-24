<template>
    <div class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col mt-3 col-lg-8">
                <settings-email />
            </div>
            <div class="w-100"></div>
            <div class="col mt-3 col-lg-8">
                <settings-password />
            </div>
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