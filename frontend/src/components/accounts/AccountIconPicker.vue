<template>
    <div class="d-flex border rounded p-1 flex-wrap">
        <div class="icon p-1 rounded"
             v-for="icon in icons"
             :key="icon.name"
             :class="{'bg-primary text-white': icon.name === value, 'text-dark': icon.name !== value}"
             @click="$emit('input', icon.name)">
            <font-awesome-icon :icon="icon.icon" fixed-width/>
        </div>
    </div>
</template>

<style scoped>
    .icon {
        cursor: pointer;
    }
</style>

<script>
    import {accountIcons} from '../../config'
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'

    export default {
        props: ['value'],
        components: {
            FontAwesomeIcon
        },
        computed: {
            icons() {
                return accountIcons
            }
        }
    }
</script>
