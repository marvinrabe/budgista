<template>
    <div class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col mt-3 col-lg-8">
                <settings-password />
            </div>
        </div>
    </div>
</template>

<script>
    import SettingsPassword from './SettingsPassword.vue'

    export default {
        components: {
            SettingsPassword
        }
    }
</script>