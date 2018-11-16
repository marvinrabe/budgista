<template>
    <app-form ref="form" @submit="deleteAccount">
        <i18n path="message.deleteAccount" tag="p">
            <strong place="name">{{ account.name }}</strong>
        </i18n>

        <template slot="actions">
            <button class="btn btn-text-dark"
                    type="button"
                    @click="$emit('cancel')">
                {{ $t('action.cancel') }}
            </button>

            <app-button variant="danger"
                        :label="$t('action.delete.account')"
                        :busy="saving">
            </app-button>
        </template>
    </app-form>
</template>

<script>
    export default {
        props: ['account'],
        data() {
            return {
                saving: false
            }
        },
        methods: {
            deleteAccount() {
                this.saving = true

                this.$store
                    .dispatch('deleteAccount', this.account)
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
