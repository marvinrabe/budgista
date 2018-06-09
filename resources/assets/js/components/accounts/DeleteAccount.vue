<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.delete.account')">
        <p slot="body"
           class="mb-0">
            <i18n path="message.deleteAccount" tag="p" class="mb-0" slot="body">
                <strong place="name">{{ account.name }}</strong>
            </i18n>
        </p>

        <div slot="footer">
            <button class="btn btn-text-dark" @click="hideModal">
                {{ $t('action.cancel') }}
            </button>
            <button class="btn btn-danger" @click="deleteAccount">
                {{ $t('action.delete.account') }}
            </button>
        </div>
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
                visible: false
            }
        },
        methods: {
            showModal(account) {
                this.visible = true
            },
            hideModal() {
                this.visible = false
            },
            deleteAccount() {
                this.$store
                    .dispatch('deleteAccount', this.account)
                    .then(() => {
                        this.hideModal()
                        this.$router.push({name: 'budget_default'})
                    })
            }
        }
    }
</script>