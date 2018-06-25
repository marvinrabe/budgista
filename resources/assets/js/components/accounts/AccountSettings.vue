<template>
    <b-dropdown variant="light" size="sm" no-caret right>
        <template slot="button-content">
            <font-awesome-icon :icon="icon"/>
        </template>
        <update-account :account="account"></update-account>
        <delete-account :account="account"></delete-account>
    </b-dropdown>
</template>

<script>
    import UpdateAccount from './UpdateAccount'
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
            UpdateAccount
        },
        computed: {
            icon() {
                return faEllipsisH
            }
        }
    }
</script>