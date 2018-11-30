<template>
    <button class="ml-auto btn btn-light btn-sm text-muted"
            :title="$t('action.create.account')"
            @click="showModal">
        <font-awesome-icon :icon="icon"/>
        <modal v-if="visible" @close="hideModal" :title="$t('action.create.account')">
            <create-account-form @success="hideModal"
                                 @cancel="hideModal"></create-account-form>
        </modal>
    </button>
</template>

<script>
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
    import {faPlus} from '@fortawesome/free-solid-svg-icons'
    import CreateAccountForm from './CreateAccountForm'

    export default {
        components: {
            CreateAccountForm,
            FontAwesomeIcon
        },
        data() {
            return {
                visible: false
            }
        },
        computed: {
            icon() {
                return faPlus
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
