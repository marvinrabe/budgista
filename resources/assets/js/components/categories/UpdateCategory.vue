<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.edit.category')">
        <app-form slot="body" id="updateCategory" @submit="updateCategory">
            <form-group name="name">
                <input type="text"
                       class="form-control"
                       slot-scope="{bindings}"
                       v-bind="bindings"
                       v-model="name"
                       v-validate="'required'"
                       v-focus>
            </form-group>
        </app-form>

        <div slot="footer">
            <div class="float-left">
                <button class="btn btn-outline-danger"
                        @click.prevent="deleteCategory"
                        :title="$t('action.delete.category')">
                    <font-awesome-icon :icon="['far', 'trash-alt']"/>
                </button>
            </div>

            <button class="btn btn-text-light"
                    @click="hideModal">
                {{ $t('action.cancel') }}
            </button>
            <button class="btn btn-primary"
                    form="updateCategory"
                    type="submit">
                {{ $t('action.save') }}
            </button>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                visible: false,
                category: null,
                name: ''
            }
        },
        methods: {
            showModal(category) {
                this.category = category;
                this.name = category.name;
                this.visible = true;
            },
            hideModal() {
                this.visible = false;
            },
            deleteCategory() {
                this.hideModal();
                this.$emit('delete:category', this.category);
            },
            updateCategory() {
                this.$store
                    .dispatch('updateCategory', {
                        id: this.category.id,
                        name: this.name
                    })
                    .then(() => {
                        this.hideModal();
                        this.$emit('update:category');
                    });
            }
        }
    }
</script>