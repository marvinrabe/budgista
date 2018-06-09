<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.edit.category')">
        <app-form ref="form" @submit="updateCategory">
            <form-group name="name">
                <input type="text"
                       class="form-control"
                       slot-scope="{bindings}"
                       v-bind="bindings"
                       v-model="name"
                       v-validate="'required'"
                       v-focus>
            </form-group>

            <template slot="actions">
                <button class="btn btn-text-dark"
                        type="button"
                        @click="hideModal">
                    {{ $t('action.cancel') }}
                </button>

                <app-button :label="$t('action.save')"
                            :busy="saving"
                            @click="updateCategory">
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
                name: ''
            }
        },
        methods: {
            showModal() {
                this.name = this.category.name;
                this.visible = true;
                this.saving = false;
            },
            hideModal() {
                this.visible = false;
            },
            updateCategory() {
                this.saving = true;

                this.$store
                    .dispatch('updateCategory', {
                        id: this.category.id,
                        name: this.name
                    })
                    .then(() => {
                        this.hideModal();
                        this.$emit('update:category');
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false;
                    });
            }
        }
    }
</script>