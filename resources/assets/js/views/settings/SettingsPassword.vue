<template>
    <app-form @submit="save" ref="form">
        <h5>{{ $t('title.updatePassword') }}</h5>

        <form-group name="password" label="oldPassword">
            <app-password :disable-strength="true" slot-scope="group">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, group.bindings)"
                       v-on="handlers"
                       v-validate="'required'"
                       v-model="form.password">
            </app-password>
        </form-group>

        <form-group name="newPassword">
            <app-password slot-scope="group">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, group.bindings)"
                       v-on="handlers"
                       v-validate="'required|min:6'"
                       v-model="form.new_password">
            </app-password>
        </form-group>

        <div slot="actions">
            <app-button :label="$t('action.settings.password')" :busy="saving"></app-button>
        </div>
    </app-form>
</template>

<script>
    export default {
        data() {
            return {
                saving: false,
                form: {
                    password: '',
                    new_password: ''
                }
            }
        },
        mounted() {
            this.reset();
        },
        methods: {
            reset() {
                this.saving = false;
                this.form.password = '';
                this.form.new_password = '';
            },
            save() {
                this.saving = true;
                this.$store.dispatch('updatePassword', this.form)
                    .then(() => {
                        this.$snotify.success(this.$t('messages.updatePassword'));
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false;
                    });
            }
        }
    }
</script>