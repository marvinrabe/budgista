<template>
    <app-form ref="form" @submit="updateGroup">
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
                        :busy="saving">
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
                name: this.group.name,
                icon: this.group.icon,
                tracking: this.group.tracking
            }
        },
        methods: {
            updateGroup() {
                this.saving = true

                this.$store
                    .dispatch('updateGroup', {
                        id: this.group.id,
                        name: this.name,
                        tracking: this.tracking,
                        icon: this.icon
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
