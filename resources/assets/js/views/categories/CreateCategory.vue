<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.create.category')">
        <app-form slot="body" id="createCategory" @submit="createCategory">
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
            <button class="btn btn-text-light" @click="hideModal">
                {{ $t('action.cancel') }}
            </button>
            <button class="btn btn-primary"
                    form="createCategory"
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
                name: ''
            }
        },
        methods: {
            showModal() {
                this.name = "";
                this.visible = true;
            },
            hideModal() {
                this.visible = false;
            },
            createCategory() {
                this.$store
                    .dispatch('createCategory', {
                        name: this.name
                    })
                    .then(() => {
                        this.hideModal();
                        this.$emit('create:category');
                    });
            }
        }
    }
</script>