<template>
    <b-dropdown-item @click="showModal"
                     v-t="'action.edit.group'">
        <modal v-if="visible" @close="hideModal" :title="$t('action.edit.group')">
            <update-group-form :group="group"
                               @success="hideModal"
                               @cancel="hideModal"></update-group-form>
        </modal>
    </b-dropdown-item>
</template>

<script>
    import UpdateGroupForm from './UpdateGroupForm'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

    export default {
        props: ['group'],
        components: {
            bDropdownItem,
            UpdateGroupForm
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