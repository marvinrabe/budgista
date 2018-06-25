<template>
    <b-dropdown-item @click="showModal"
                     v-t="'action.delete.account'">
        <modal v-if="visible" @close="hideModal" :title="$t('action.delete.account')">
            <delete-account-form :account="account"
                                 @success="onSuccess"
                                 @cancel="hideModal"></delete-account-form>
        </modal>
    </b-dropdown-item>
</template>

<script>
    import DeleteAccountForm from './DeleteAccountForm'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

    export default {
        props: ['account'],
        components: {
            bDropdownItem,
            DeleteAccountForm
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