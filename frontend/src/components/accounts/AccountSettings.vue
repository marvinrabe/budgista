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
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
    import {faEllipsisH} from '@fortawesome/free-solid-svg-icons'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'

    export default {
        props: ['account'],
        components: {
            bDropdown,
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
