<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.delete.category')">
        <app-form slot="body" @submit="deleteCategory" id="deleteCategory">
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
        </app-form>
        <div slot="footer">
            <button class="btn btn-text-light" @click="hideModal">
                {{ $t('action.cancel') }}
            </button>
            <button class="btn btn-danger" form="deleteCategory" type="submit">
                {{ $t('action.delete.category') }}
            </button>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                visible: false,
                validated: false,
                old_category_id: null,
                new_category_id: ""
            }
        },
        computed: {
            categories() {
                return this.$store.getters.sortedCategories.filter((item) => item.id !== this.old_category_id);
            }
        },
        methods: {
            showModal(category) {
                this.old_category_id = category.id;
                this.new_category_id = "";
                this.visible = true;
            },
            hideModal() {
                this.visible = false;
            },
            deleteCategory() {
                let oldCategory = this.$store.getters.findCategoryById(this.old_category_id);
                let newCategory = this.$store.getters.findCategoryById(this.new_category_id);

                this.$store
                    .dispatch('deleteCategory', {
                        oldCategory: oldCategory,
                        newCategory: newCategory
                    })
                    .then(() => {
                        this.hideModal();
                        this.$emit('delete:category', oldCategory)
                    });
            }
        }
    }
</script>