<template>
    <app-form ref="form" @submit="updateAccount">
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
                    @click="$emit('cancel')">
                {{ $t('action.cancel') }}
            </button>

            <app-button :label="$t('action.save')"
                        :busy="saving"
                        @click="updateAccount">
            </app-button>
        </template>
    </app-form>
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
                saving: false,
                name: this.account.name,
                icon: this.account.icon,
                tracking: this.account.tracking
            }
        },
        methods: {
            updateAccount() {
                this.saving = true

                this.$store
                    .dispatch('updateAccount', {
                        id: this.account.id,
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