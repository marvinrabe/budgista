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
        </app-form>

        <div slot="footer">
            <div class="float-left">
                <button class="btn btn-outline-danger"
                        :title="$t('action.delete.account')"
                        @click="deleteAccount">
                    <font-awesome-icon :icon="['far', 'trash-alt']"/>
                </button>
            </div>

            <button class="btn btn-text-light" @click="hideModal">
                {{ $t('action.cancel') }}
            </button>
            <button class="btn btn-primary" form="updateAccount" type="submit">
                {{ $t('action.save') }}
            </button>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                visible: false,
                account: null,
                name: ''
            }
        },
        methods: {
            showModal(account) {
                this.account = account;
                this.name = account.name;
                this.visible = true;
            },
            hideModal() {
                this.visible = false;
            },
            updateAccount() {
                this.$store
                    .dispatch('updateAccount', {
                        id: this.account.id,
                        name: this.name
                    })
                    .then(() => {
                        this.hideModal();
                    });
            },
            deleteAccount() {
                this.$store
                    .dispatch('deleteAccount', this.account)
                    .then(() => {
                        this.hideModal();
                        this.$router.push({name: 'budget_default'});
                    });
            }
        }
    }
</script>