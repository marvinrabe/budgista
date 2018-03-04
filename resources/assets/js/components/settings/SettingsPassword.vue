<template>
    <app-form @submit="save">
        <h5>{{ $t('title.updatePassword') }}</h5>

        <form-group name="oldPassword">
            <app-password :disable-strength="true" slot-scope="group">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, group.bindings)"
                       v-on="handlers"
                       v-validate.initial="'required'"
                       v-model="form.password">
            </app-password>
        </form-group>

        <form-group name="newPassword">
            <app-password slot-scope="group">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, group.bindings)"
                       v-on="handlers"
                       v-validate.initial="'required|min:6'"
                       v-model="form.new_password">
            </app-password>
        </form-group>

        <div slot="actions">
            <button class="btn btn-primary" :disabled="saving">
                <font-awesome-icon icon="spinner" spin v-show="saving"/>
                {{ $t('action.settings.password') }}
            </button>
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
                        this.saving = false;
                        this.$snotify.success(this.$t('messages.updatePassword'), this.$t('notification.successful'));
                    })
                    .catch(exception => {
                        this.saving = false;
                        if (_.has(exception, 'response.data.errors')) {
                            const keys = _.keys(exception.response.data.errors);
                            this.$snotify.error(_.head(exception.response.data.errors[_.head(keys)]), this.$t('notification.error'));
                        } else {
                            this.$snotify.error(this.$t('notification.tryAgain'), this.$t('notification.unexpectedError'));
                        }
                    });
            }
        }
    }
</script>