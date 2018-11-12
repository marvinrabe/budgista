<template>
    <b-dropdown-item @click="showModal"
                     v-t="'action.create.category'">
        <modal v-if="visible" @close="hideModal" :title="$t('action.create.category')">
            <create-category-form :group="group"
                                  @success="hideModal"
                                  @cancel="hideModal"></create-category-form>
        </modal>
    </b-dropdown-item>
</template>

<script>
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'
    import CreateCategoryForm from './CreateCategoryForm'

    export default {
        props: ['group'],
        components: {
            bDropdownItem,
            CreateCategoryForm
        },
        data() {
            return {
                visible: false
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