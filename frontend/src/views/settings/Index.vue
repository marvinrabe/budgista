<template>
    <div class="main">
        <AppToolbar :title="$t('title.settings')"/>

        <div class="card">
            <div class="card-body">
                <settings-general/>
            </div>
        </div>
    </div>
</template>

<script>
    import AppToolbar from '../../components/AppToolbar'
    import SettingsGeneral from '../../components/settings/SettingsGeneral.vue'

    export default {
        components: {
            AppToolbar,
            SettingsGeneral
        }
    }
</script>
