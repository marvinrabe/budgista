<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.delete.category')">
        <app-form ref="form" @submit="deleteCategory">

            <form-group name="transferTransactions">
                <select class="form-control"
                        v-model="new_category_id"
                        slot-scope="{bindings}"
                        v-bind="bindings">
                    <option value="">{{ $t('form.uncategorized') }}</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </form-group>

            <i18n path="message.deleteCategory" tag="p" class="mb-0">
                <strong place="name">{{ category.name }}</strong>
            </i18n>

            <template slot="actions">
                <button class="btn btn-text-dark"
                        type="button"
                        @click="hideModal">
                    {{ $t('action.cancel') }}
                </button>

                <app-button variant="danger"
                            :label="$t('action.delete.category')"
                            :busy="saving"
                            @click="createCategory">
                </app-button>
            </template>

        </app-form>
    </modal>
</template>

<script>
    export default {
        props: ['category'],
        data() {
            return {
                visible: false,
                saving: false,
                old_category_id: null,
                new_category_id: ''
            }
        },
        computed: {
            categories() {
                return this.$store.getters.sortedCategories.filter((item) => item.id !== this.old_category_id)
            }
        },
        methods: {
            showModal() {
                this.old_category_id = this.category.id
                this.new_category_id = ''
                this.visible = true
                this.saving = false
            },
            hideModal() {
                this.visible = false
            },
            deleteCategory() {
                let oldCategory = this.$store.getters.findCategoryById(this.old_category_id)
                let newCategory = this.$store.getters.findCategoryById(this.new_category_id)
                this.saving = true

                this.$store
                    .dispatch('deleteCategory', {
                        oldCategory: oldCategory,
                        newCategory: newCategory
                    })
                    .then(() => {
                        this.hideModal()
                        this.$emit('delete:category', oldCategory)
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false
                    })
            }
        }
    }
</script>