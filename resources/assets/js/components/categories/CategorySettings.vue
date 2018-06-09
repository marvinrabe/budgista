<template>
    <b-dropdown variant="text-dark" size="sm" no-caret right>
        <template slot="button-content">
            <font-awesome-icon :icon="icon"/>
        </template>
        <b-dropdown-item
                @click="$refs.updateCategory.showModal()"
                v-t="'action.edit.category'">
        </b-dropdown-item>
        <update-category :category="category" ref="updateCategory"></update-category>
        <b-dropdown-item
                @click="$refs.deleteCategory.showModal()"
                v-t="'action.delete.category'">
        </b-dropdown-item>
        <delete-category :category="category" ref="deleteCategory"></delete-category>
    </b-dropdown>
</template>

<script>
    import DeleteCategory from './DeleteCategory'
    import UpdateCategory from './UpdateCategory'
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faEllipsisH from '@fortawesome/fontawesome-free-solid/faEllipsisH'
    import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

    export default {
        props: ['category'],
        components: {
            bDropdown,
            bDropdownItem,
            FontAwesomeIcon,
            DeleteCategory,
            UpdateCategory
        },
        computed: {
            icon() {
                return faEllipsisH
            }
        }
    }
</script>