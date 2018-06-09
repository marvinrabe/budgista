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
            <button class="btn btn-text-dark" @click="hideModal">
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
        props: ['category'],
        data() {
            return {
                visible: false,
                name: ''
            }
        },
        methods: {
            showModal() {
                this.name = this.category.name;
                this.visible = true;
            },
            hideModal() {
                this.visible = false;
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