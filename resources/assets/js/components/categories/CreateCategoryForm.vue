<template>
    <app-form ref="form" @submit="createCategory">
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
                    @click="$emit('cancel')">
                {{ $t('action.cancel') }}
            </button>

            <app-button :label="$t('action.save')"
                        :busy="saving"
                        @click="createCategory">
            </app-button>
        </template>
    </app-form>
</template>

<script>
    export default {
        props: ['group'],
        data() {
            return {
                saving: false,
                name: ''
            }
        },
        methods: {
            createCategory() {
                this.saving = true

                this.$store
                    .dispatch('createCategory', {
                        name: this.name,
                        group_id: this.group ? this.group.id : null
                    })
                    .then(() => {
                        this.$emit('success')
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false
                    })
            }
        }
    }
</script>