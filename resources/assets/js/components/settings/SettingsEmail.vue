<template>
    <app-form @submit="save">
        <h5>{{ $t('title.updateEmail') }}</h5>

        <form-group name="email">
            <input type="email"
                   class="form-control"
                   slot-scope="{bindings}"
                   v-bind="bindings"
                   v-validate.initial="'required|email'"
                   v-model="form.email">
        </form-group>

        <form-group name="password">
            <app-password :disable-strength="true" slot-scope="group">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, group.bindings)"
                       v-on="handlers"
                       v-validate.initial="'required'"
                       v-model="form.password">
            </app-password>
        </form-group>

        <div slot="actions">
            <button class="btn btn-primary" type="submit" :disabled="saving">
                <font-awesome-icon icon="spinner" spin v-show="saving"/>
                {{ $t('action.settings.email') }}
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
                    email: '',
                    password: ''
                }
            }
        },
        mounted() {
            this.reset();
        },
        methods: {
            reset() {
                this.saving = false;
                this.form.email = this.$store.state.user.email;
                this.form.password = '';
            },
            save() {
                this.saving = true;
                this.$store.dispatch('updateEmail', this.form)
                    .then(() => {
                        this.saving = false;
                        this.$snotify.success(this.$t('messages.updateEmail'), this.$t('notification.successful'));
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