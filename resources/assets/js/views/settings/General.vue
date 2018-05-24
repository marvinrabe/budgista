<template>
    <div class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col mt-3 col-lg-8">
                <settings-general />
            </div>
        </div>
    </div>
</template>

<script>
    import SettingsGeneral from './SettingsGeneral.vue'

    export default {
        components: {
            SettingsGeneral
        }
    }
</script>