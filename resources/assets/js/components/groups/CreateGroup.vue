<template>
    <b-dropdown-item @click="showModal"
                     v-t="'action.create.group'">
        <modal v-if="visible" @close="hideModal" :title="$t('action.create.group')">
            <create-group-form @success="hideModal"
                               @cancel="hideModal"></create-group-form>
        </modal>
    </b-dropdown-item>
</template>

<script>
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faPlus from '@fortawesome/fontawesome-free-solid/faPlus'
    import CreateGroupForm from './CreateGroupForm'
    import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

    export default {
        components: {
            bDropdownItem,
            CreateGroupForm,
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