<template>
    <b-dropdown-item @click="showModal"
                     v-t="'action.edit.account'">
        <modal v-if="visible" @close="hideModal" :title="$t('action.edit.account')">
            <update-account-form :account="account"
                                 @success="hideModal"
                                 @cancel="hideModal"></update-account-form>
        </modal>
    </b-dropdown-item>
</template>

<script>
    import UpdateAccountForm from './UpdateAccountForm'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

    export default {
        props: ['account'],
        components: {
            bDropdownItem,
            UpdateAccountForm
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