<template>
    <b-dropdown variant="text-dark" size="sm" toggle-class="p-0" no-caret right>
        <template slot="button-content">
            <font-awesome-icon :icon="icon" fixed-width/>
        </template>
        <update-group :group="group"></update-group>
        <delete-group :group="group"></delete-group>
    </b-dropdown>
</template>

<script>
    import DeleteGroup from './DeleteGroup'
    import UpdateGroup from './UpdateGroup'
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faEllipsisH from '@fortawesome/fontawesome-free-solid/faEllipsisH'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

    export default {
        props: ['group'],
        components: {
            bDropdown,
            bDropdownItem,
            FontAwesomeIcon,
            DeleteGroup,
            UpdateGroup
        },
        computed: {
            icon() {
                return faEllipsisH
            }
        }
    }
</script>