<template>
    <b-dropdown variant="light" size="sm" no-caret right>
        <template slot="button-content">
            <font-awesome-icon :icon="icon"/>
        </template>
        <b-dropdown-item
                @click="$refs.createCategory.showModal()"
                v-t="'action.create.category'">
        </b-dropdown-item>
        <create-category ref="createCategory"></create-category>
    </b-dropdown>
</template>

<script>
    import CreateCategory from '../categories/CreateCategory'
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faEllipsisH from '@fortawesome/fontawesome-free-solid/faEllipsisH'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

    export default {
        props: ['month'],
        components: {
            bDropdown,
            bDropdownItem,
            FontAwesomeIcon,
            CreateCategory
        },
        computed: {
            icon() {
                return faEllipsisH
            }
        }
    }
</script>