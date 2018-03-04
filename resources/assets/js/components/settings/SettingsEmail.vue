<template>
    <app-form @submit="save">
        <h5>E-Mail Adresse ändern</h5>

        <form-group name="email">
            <input type="email"
                   class="form-control"
                   slot-scope="{bindings}"
                   v-bind="bindings"
                   v-validate.initial="'required|email'"
                   v-model="form.email">
        </form-group>

        <form-group name="password">
            <app-password :disable-strength="true" slot-scope="{groupBindings}">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, groupBindings)"
                       v-on="handlers"
                       v-validate.initial="'required'"
                       v-model="form.password">
            </app-password>
        </form-group>

        <div slot="actions">
            <button class="btn btn-text-light" @click.prevent="reset">
                {{ $t('action.cancel') }}
            </button>

            <button class="btn btn-primary">
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
                this.form.email = this.$store.state.user.email;
                this.form.password = '';
            },
            save() {
                console.log('save');
            }
        }
    }
</script>