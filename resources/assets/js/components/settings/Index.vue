<template>
    <div class="main">
        <app-toolbar :title="$t('title.settings')"/>

        <div class="card">
            <div class="card-body">
                <settings-general/>
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