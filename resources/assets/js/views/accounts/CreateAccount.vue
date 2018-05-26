<template>
    <modal v-if="visible" @close="hideModal" :title="$t('action.create.account')">
        <app-form slot="body" id="createAccount" @submit="createAccount">
            <form-group name="name">
                <input type="text"
                       class="form-control"
                       slot-scope="{bindings}"
                       v-bind="bindings"
                       v-model="name"
                       v-validate="'required'"
                       v-focus>
            </form-group>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="tracking" v-model="tracking" :value="true">
                <label class="form-check-label" for="tracking" v-t="'form.trackingAccount'"></label>
            </div>
        </app-form>

        <div slot="footer">
            <button class="btn btn-text-dark" @click="hideModal">
                {{ $t('action.cancel') }}
            </button>
            <button class="btn btn-primary"
                    form="createAccount"
                    type="submit">
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
                name: '',
                tracking: false
            }
        },
        methods: {
            showModal() {
                this.name = '';
                this.tracking = false;
                this.visible = true;
            },
            hideModal() {
                this.visible = false;
            },
            createAccount() {
                this.$store
                    .dispatch('createAccount', {
                        name: this.name,
                        tracking: this.tracking
                    })
                    .then(() => {
                        this.hideModal();
                        this.$emit('create:account');
                    });
            }
        }
    }
</script>