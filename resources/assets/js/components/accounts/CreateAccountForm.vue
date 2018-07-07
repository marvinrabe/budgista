<template>
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

        <form-group name="initialBalance">
            <app-money-input
                    slot-scope="{bindings}"
                    v-bind="bindings"
                    v-model="initialBalance"
                    v-validate="'numeric'">
            </app-money-input>
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
                    @click="$emit('cancel')">
                {{ $t('action.cancel') }}
            </button>

            <app-button :label="$t('action.save')"
                        :busy="saving"
                        @click="createAccount">
            </app-button>
        </template>
    </app-form>
</template>

<script>
    import AccountIconPicker from './AccountIconPicker'
    import AppMoneyInput from '../form/AppMoneyInput'

    export default {
        components: {
            AccountIconPicker,
            AppMoneyInput
        },
        data() {
            return {
                saving: false,
                name: '',
                initialBalance: 0,
                icon: 'credit-card',
                tracking: false
            }
        },
        methods: {
            createAccount() {
                this.saving = true

                this.$store
                    .dispatch('createAccount', {
                        name: this.name,
                        tracking: this.tracking,
                        icon: this.icon,
                        initial_balance: this.initialBalance
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