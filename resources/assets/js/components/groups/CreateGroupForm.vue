<template>
    <app-form ref="form" @submit="createGroup">
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
                        @click="createGroup">
            </app-button>
        </template>
    </app-form>
</template>

<script>

    export default {
        data() {
            return {
                saving: false,
                name: ''
            }
        },
        methods: {
            createGroup() {
                this.saving = true

                this.$store
                    .dispatch('createGroup', {
                        name: this.name
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