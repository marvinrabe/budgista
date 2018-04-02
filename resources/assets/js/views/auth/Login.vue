<template>
    <div class="auth">
        <div class="cover">
            <div class="container text-center">
                <span class="h2 logo" v-t="'app.name'"></span>
            </div>
        </div>

        <div class="container overlap">
            <div class="row justify-content-md-center">
                <div class="col-sm-12 col-md-6 col-lg-5 center">
                    <div class="card">
                        <div class="card-body">

                            <h1 class="card-title h4" v-t="'title.login'"></h1>

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
                                    <div class="form-group mr-auto">
                                        <div class="form-check">
                                            <input id="remember"
                                                   class="form-check-input"
                                                   type="checkbox"
                                                   v-model="form.remember">
                                            <label for="remember"
                                                   class="form-check-label"
                                                   v-t="'form.remember'"></label>
                                        </div>
                                    </div>

                                    <app-button :label="$t('action.login')" :busy="loggingIn"></app-button>
                                </template>
                            </app-form>

                        </div>

                        <div class="card-body card-body-secondary text-center">

                            abc
                            <a href="#">
                                def
                            </a>

                        </div>
                    </div>

                    <p class="text-center mt-3">
                        <a class="text-muted" href="#">
                            abcdef
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: '',
                    remember: false
                },
                loggingIn: false
            };
        },
        methods: {
            login() {
                this.loggingIn = true;
                this.$store.dispatch('login', this.form)
                    .then(() => {
                        this.$router.push({name: 'budget_default'});
                    })
                    .finally(() => {
                        this.loggingIn = false;
                    });
            }
        }
    }
</script>