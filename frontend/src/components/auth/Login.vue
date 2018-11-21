<template>
    <div class="card">
        <div class="card-body">
            <h1 class="card-title h4 mb-3" v-t="'title.login'"></h1>

            <app-form @submit="login" ref="form">

                <form-group name="email">
                    <input type="email"
                           class="form-control"
                           slot-scope="{bindings}"
                           v-bind="bindings"
                           v-validate="'required|email'"
                           data-vv-validate-on="input"
                           v-model="form.email"
                           v-focus>
                </form-group>

                <form-group name="password">
                    <template slot-scope="{bindings}">
                        <div class="float-right">
                            <router-link class="text-muted small"
                                         :to="{name: 'send_reset'}"
                                         v-t="'message.forgotPassword'">
                            </router-link>
                        </div>
                        <PasswordInput
                                v-bind="bindings"
                                v-model="form.password"
                                :disable-strength="true"
                        />
                    </template>
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

                    <app-button :label="$t('action.login')"
                                :busy="loading">
                    </app-button>
                </template>
            </app-form>

        </div>

        <div class="card-body card-body-secondary text-center">
            <span v-t="'message.noAccount'"></span>
            <router-link :to="{name: 'register'}" v-t="'message.noAccountSignUp'"></router-link>
        </div>
    </div>
</template>

<script>
    import PasswordInput from '@/components/form/PasswordInput'

    export default {
        components: {
            PasswordInput
        },
        data() {
            return {
                form: {
                    email: '',
                    password: '',
                    remember: false
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
                        this.$ga.event('Login', 'submit')
                    },
                    error: function (error) {
                        this.loading = false
                        if (error.response && error.response.status === 401) {
                            this.$refs.form.addError('email', this.$t('message.loginFailed'))
                        } else {
                            this.$refs.form.error(error)
                        }
                    },
                    rememberMe: this.form.remember,
                    redirect: {name: 'budget_default'}
                })
            }
        }
    }
</script>
