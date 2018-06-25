<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.edit.account')">
        <update-account-form :account="account" @success="hideModal"></update-account-form>
    </modal>
</template>

<script>
    import UpdateAccountForm from './UpdateAccountForm'

    export default {
        props: ['account'],
        components: {
            UpdateAccountForm
        },
        data() {
            return {
                visible: false,
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