<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.edit.account')">
        <app-form slot="body" id="updateAccount" @submit="updateAccount">
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
        </app-form>

        <template slot="footer">
            <button class="btn btn-text-dark" @click="hideModal">
                {{ $t('action.cancel') }}
            </button>
            <button class="btn btn-primary" form="updateAccount" type="submit">
                {{ $t('action.save') }}
            </button>
        </template>
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
                name: '',
                icon: '',
                tracking: false
            }
        },
        methods: {
            showModal() {
                this.name = this.account.name;
                this.tracking = this.account.tracking;
                this.icon = this.account.icon;
                this.visible = true;
            },
            hideModal() {
                this.visible = false;
            },
            updateAccount() {
                this.$store
                    .dispatch('updateAccount', {
                        id: this.account.id,
                        name: this.name,
                        tracking: this.tracking,
                        icon: this.icon
                    })
                    .then(() => {
                        this.hideModal();
                    });
            }
        }
    }
</script>