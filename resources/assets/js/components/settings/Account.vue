<template>
    <div class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col mt-3 col-lg-8">
                <settings-general />
            </div>
            <div class="w-100"></div>
            <div class="col mt-3 col-lg-8">
                <settings-email />
            </div>
        </div>
    </div>
</template>

<script>
    import SettingsGeneral from './SettingsGeneral.vue'
    import SettingsEmail from './SettingsEmail.vue'

    export default {
        components: {
            SettingsGeneral,
            SettingsEmail
        }
    }
</script>