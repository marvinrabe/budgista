<template>
    <b-dropdown variant="light" size="sm" no-caret right>
        <template slot="button-content">
            <font-awesome-icon :icon="icon"/>
        </template>
        <b-dropdown-item
                @click="$refs.updateAccount.showModal()"
                v-t="'action.edit.account'">
        </b-dropdown-item>
        <update-account-modal :account="account" ref="updateAccount"></update-account-modal>
        <b-dropdown-item
                @click="$refs.deleteAccount.showModal()"
                v-t="'action.delete.account'">
        </b-dropdown-item>
        <delete-account :account="account" ref="deleteAccount"></delete-account>
    </b-dropdown>
</template>

<script>
    import UpdateAccountModal from './UpdateAccountModal'
    import DeleteAccount from './DeleteAccount'
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faEllipsisH from '@fortawesome/fontawesome-free-solid/faEllipsisH'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

    export default {
        props: ['account'],
        components: {
            bDropdown,
            bDropdownItem,
            FontAwesomeIcon,
            DeleteAccount,
            UpdateAccountModal
        },
        computed: {
            icon() {
                return faEllipsisH
            }
        }
    }
</script>