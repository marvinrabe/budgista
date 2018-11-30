<template>
    <b-dropdown variant="text-dark" size="sm" toggle-class="p-0" no-caret right>
        <template slot="button-content">
            <font-awesome-icon :icon="icon" fixed-width/>
        </template>
        <create-category :group="group"></create-category>
        <b-dropdown-divider></b-dropdown-divider>
        <update-group :group="group"></update-group>
        <delete-group :group="group"></delete-group>
    </b-dropdown>
</template>

<script>
    import DeleteGroup from './DeleteGroup'
    import UpdateGroup from './UpdateGroup'
    import CreateCategory from '../categories/CreateCategory'
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
    import {faEllipsisH} from '@fortawesome/free-solid-svg-icons'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
    import bDropdownDivider from 'bootstrap-vue/es/components/dropdown/dropdown-divider'

    export default {
        props: ['group'],
        components: {
            bDropdown,
            bDropdownDivider,
            FontAwesomeIcon,
            CreateCategory,
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
