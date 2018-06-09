<template>
    <app-form @submit="save" ref="form">
        <h5>{{ $t('title.updateEmail') }}</h5>

        <form-group name="email">
            <input type="email"
                   class="form-control"
                   slot-scope="{bindings}"
                   v-bind="bindings"
                   v-validate="'required|email'"
                   v-model="form.email">
        </form-group>

        <form-group name="password">
            <app-password :disable-strength="true" slot-scope="group">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, group.bindings)"
                       v-on="handlers"
                       v-validate="'required'"
                       v-model="form.password">
            </app-password>
        </form-group>

        <div slot="actions">
            <app-button :label="$t('action.settings.email')" :busy="saving"></app-button>
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
                        this.$snotify.success(this.$t('message.updateEmail'));
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false;
                    });
            }
        }
    }
</script>