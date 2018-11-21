<template>
    <div class="card">
        <div class="card-body">
            <h1 class="card-title h4 mb-3" v-t="'title.reset'"></h1>

            <app-form @submit="reset" ref="form">

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
                    <PasswordInput
                            slot-scope="{bindings}"
                            v-bind="bindings"
                            v-model="form.password"
                            validation="required|min:6"
                    />
                </form-group>

                <template slot="actions">
                    <app-button :label="$t('action.reset')"
                                :busy="loading"
                                :disabled="loggingIn">
                    </app-button>
                </template>
            </app-form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import PasswordInput from '@/components/form/PasswordInput'

    export default {
        props: ['token'],
        components: {
            PasswordInput
        },
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                loading: false,
                loggingIn: false
            }
        },
        methods: {
            reset() {
                this.loading = true

                let email = this.form.email
                let password = this.form.password

                axios
                    .put('/auth/reset-password/' + this.token, {
                        email: email,
                        password: password
                    })
                    .then(() => {
                        this.$snotify.success(this.$t('message.resetPasswordSuccessful'))
                        this.login(email, password)
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.loading = false
                    })
            },
            login(email, password) {
                this.loggingIn = true

                this.$auth.login({
                    params: {
                        email: email,
                        password: password
                    },
                    error: function (error) {
                        if (error.response && error.response.status === 401) {
                            this.$refs.form.addError('email', this.$t('message.loginFailed'))
                        } else {
                            this.$refs.form.error(error)
                        }
                    },
                    redirect: {name: 'budget_default'}
                })
            }
        }
    }
</script>
