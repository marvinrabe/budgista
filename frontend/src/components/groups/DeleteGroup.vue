<template>
    <b-dropdown-item @click="showModal"
                     v-t="'action.delete.group'">
        <modal v-if="visible" @close="hideModal" :title="$t('action.delete.group')">
            <delete-group-form :group="group"
                                 @success="onSuccess"
                                 @cancel="hideModal"></delete-group-form>
        </modal>
    </b-dropdown-item>
</template>

<script>
    import DeleteGroupForm from './DeleteGroupForm'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

    export default {
        props: ['group'],
        components: {
            bDropdownItem,
            DeleteGroupForm
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
                console.log('hide')
                this.visible = false
            },
            onSuccess() {
                console.log('hello')
                this.$router.push({name: 'budget_default'})
                this.hideModal()
            }
        }
    }
</script>