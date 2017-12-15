<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.delete.category')">
        <form slot="body" novalidate
              @submit.stop.prevent="deleteCategory">
            <div class="form-group">
                <label for="category" v-html="$t('form.transferTransactions')"></label>
                <select id="category" class="form-control" v-model="new_category_id">
                    <option value="">{{ $t('form.uncategorized') }}</option>
                    <option v-for="category in sortedCategories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
        </form>
        <div slot="footer">
            <button class="btn btn-light" @click="hideModal">
                {{ $t('action.cancel') }}
            </button>
            <button class="btn btn-danger" @click="deleteCategory">
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
            sortedCategories() {
                return this.$store.getters.sortedCategories.filter((item) => item.id !== this.old_category_id);
            }
        },
        methods: {
            showModal(category_id) {
                this.old_category_id = category_id;
                this.new_category_id = "";
                this.visible = true;
            },
            hideModal() {
                this.visible = false;
            },
            deleteCategory() {
                let oldCategory = this.$store.getters.findCategoryById(this.old_category_id);
                let newCategory = this.$store.getters.findCategoryById(this.new_category_id);

                this.$store.dispatch('deleteCategory', {
                    oldCategory: oldCategory,
                    newCategory: newCategory
                }).then(response => {
                    this.hideModal();
                });
            }
        }
    }
</script>