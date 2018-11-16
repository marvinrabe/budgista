<template>
    <b-dropdown variant="light" size="sm" no-caret right>
        <template slot="button-content">
            <font-awesome-icon :icon="icon"/>
        </template>
        <create-group></create-group>
        <create-category></create-category>
    </b-dropdown>
</template>

<script>
    import CreateGroup from '../groups/CreateGroup'
    import CreateCategory from '../categories/CreateCategory'
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
    import {faEllipsisH} from '@fortawesome/free-solid-svg-icons'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'

    export default {
        props: ['month'],
        components: {
            bDropdown,
            FontAwesomeIcon,
            CreateCategory,
            CreateGroup
        },
        computed: {
            icon() {
                return faEllipsisH
            }
        }
    }
</script>
