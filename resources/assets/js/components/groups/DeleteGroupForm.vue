<template>
    <app-form ref="form" @submit="deleteGroup">
        <i18n path="message.deleteGroup" tag="p">
            <strong place="name">{{ group.name }}</strong>
        </i18n>

        <template slot="actions">
            <button class="btn btn-text-dark"
                    type="button"
                    @click="$emit('cancel')">
                {{ $t('action.cancel') }}
            </button>

            <app-button variant="danger"
                        :label="$t('action.delete.group')"
                        :busy="saving"
                        @click="deleteGroup">
            </app-button>
        </template>
    </app-form>
</template>

<script>
    export default {
        props: ['group'],
        data() {
            return {
                saving: false
            }
        },
        methods: {
            deleteGroup() {
                this.saving = true

                this.$store
                    .dispatch('deleteGroup', this.group)
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