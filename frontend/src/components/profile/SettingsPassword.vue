<template>
    <app-form @submit="save" ref="form">

        <form-group name="password" label="oldPassword">
            <PasswordInput :disable-strength="true" slot-scope="group">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, group.bindings)"
                       v-on="handlers"
                       v-validate="'required'"
                       v-model="form.password">
            </PasswordInput>
        </form-group>

        <form-group name="newPassword">
            <PasswordInput slot-scope="group">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, group.bindings)"
                       v-on="handlers"
                       v-validate="'required|min:6'"
                       v-model="form.new_password">
            </PasswordInput>
        </form-group>

        <div slot="actions">
            <app-button :label="$t('action.settings.password')"
                        :busy="saving">
            </app-button>
        </div>
    </app-form>
</template>

<script>
    import PasswordInput from '@/components/form/PasswordInput'

    export default {
        components: {
            PasswordInput
        },
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
                        this.$snotify.success(this.$t('message.updatePassword'));
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false;
                    });
            }
        }
    }
</script>
