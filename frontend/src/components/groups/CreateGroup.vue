<template>
    <b-dropdown-item @click="showModal"
                     v-t="'action.create.group'">
        <modal v-if="visible" @close="hideModal" :title="$t('action.create.group')">
            <create-group-form @success="hideModal"
                               @cancel="hideModal"></create-group-form>
        </modal>
    </b-dropdown-item>
</template>

<script>
    import CreateGroupForm from './CreateGroupForm'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

    export default {
        components: {
            bDropdownItem,
            CreateGroupForm
        },
        data() {
            return {
                visible: false
            }
        },
        methods: {
            showModal() {
                this.visible = true
            },
            hideModal() {
                this.visible = false
            }
        }
    }
</script>
