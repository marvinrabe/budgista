<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.create.account')">
        <app-form ref="form" @submit="createAccount">
            <form-group name="name">
                <input type="text"
                       class="form-control"
                       slot-scope="{bindings}"
                       v-bind="bindings"
                       v-model="name"
                       v-validate="'required'"
                       v-focus>
            </form-group>

            <form-group name="icon">
                <account-icon-picker v-model="icon"></account-icon-picker>
            </form-group>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="tracking" v-model="tracking" :value="true">
                <label class="form-check-label" for="tracking" v-t="'form.trackingAccount'"></label>
            </div>

            <template slot="actions">
                <button class="btn btn-text-dark"
                        type="button"
                        @click="hideModal">
                    {{ $t('action.cancel') }}
                </button>

                <app-button :label="$t('action.save')"
                            :busy="saving"
                            @click="createAccount">
                </app-button>
            </template>
        </app-form>
    </modal>
</template>

<script>
    import AccountIconPicker from './AccountIconPicker'

    export default {
        components: {
            AccountIconPicker
        },
        data() {
            return {
                visible: false,
                saving: false,
                name: '',
                icon: 'credit-card',
                tracking: false
            }
        },
        methods: {
            showModal() {
                this.name = ''
                this.tracking = false
                this.icon = 'credit-card'
                this.visible = true
                this.saving = false
            },
            hideModal() {
                this.visible = false
            },
            createAccount() {
                this.saving = true

                this.$store
                    .dispatch('createAccount', {
                        name: this.name,
                        tracking: this.tracking,
                        icon: this.icon
                    })
                    .then(() => {
                        this.hideModal()
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false
                    })
            }
        }
    }
</script>