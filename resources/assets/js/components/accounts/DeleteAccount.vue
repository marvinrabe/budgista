<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.delete.account')">
        <app-form ref="form" @submit="deleteAccount">
            <i18n path="message.deleteAccount" tag="p">
                <strong place="name">{{ account.name }}</strong>
            </i18n>

            <template slot="actions">
                <button class="btn btn-text-dark"
                        type="button"
                        @click="hideModal">
                    {{ $t('action.cancel') }}
                </button>

                <app-button variant="danger"
                            :label="$t('action.delete.account')"
                            :busy="saving"
                            @click="deleteAccount">
                </app-button>
            </template>
        </app-form>
    </modal>
</template>

<script>
    import AccountIconPicker from './AccountIconPicker'

    export default {
        props: ['account'],
        components: {
            AccountIconPicker
        },
        data() {
            return {
                visible: false,
                saving: false
            }
        },
        methods: {
            showModal() {
                this.visible = true
                this.saving = false
            },
            hideModal() {
                this.visible = false
            },
            deleteAccount() {
                this.saving = true

                this.$store
                    .dispatch('deleteAccount', this.account)
                    .then(() => {
                        this.hideModal()
                        this.$router.push({name: 'budget_default'})
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false
                    })
            }
        }
    }
</script>