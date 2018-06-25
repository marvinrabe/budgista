<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.create.account')">
        <create-account-form @success="hideModal"></create-account-form>
    </modal>
</template>

<script>
    import CreateAccountForm from './CreateAccountForm'

    export default {
        components: {
            CreateAccountForm
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