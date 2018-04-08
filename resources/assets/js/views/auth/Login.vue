<template>
    <div class="card">
        <div class="card-body">
            <h1 class="card-title h4 mb-3" v-t="'title.login'"></h1>

            <app-form @submit="login">

                <form-group name="email">
                    <input type="email"
                           class="form-control"
                           slot-scope="{bindings}"
                           v-bind="bindings"
                           v-validate.initial="'required|email'"
                           v-model="form.email"
                           v-focus>
                </form-group>

                <form-group name="password">
                    <app-password slot-scope="group" :disable-strength="true">
                        <input class="form-control"
                               slot-scope="{bindings, handlers}"
                               v-bind="Object.assign(bindings, group.bindings)"
                               v-on="handlers"
                               v-validate.initial="'required'"
                               v-model="form.password">
                    </app-password>
                </form-group>

                <template slot="actions">
                    <div class="mr-auto">
                        <a class="text-muted" href="#" v-t="'messages.forgotPassword'"></a>
                    </div>

                    <app-button :label="$t('action.login')" :busy="loading"></app-button>
                </template>
            </app-form>

        </div>

        <div class="card-body card-body-secondary text-center">
            <span v-t="'messages.noAccount'"></span>
            <router-link :to="{name: 'register'}" v-t="'messages.noAccountSignUp'"></router-link>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                loading: false
            }
        },
        methods: {
            login() {
                this.loading = true
                this.$auth.login({
                    params: {
                        email: this.form.email,
                        password: this.form.password
                    },
                    success: function () {
                        this.loading = false
                    },
                    error: function () {
                        this.loading = false
                    },
                    rememberMe: true,
                    redirect: {name: 'budget_default'},
                    fetchUser: false
                })
            }
        }
    }
</script>