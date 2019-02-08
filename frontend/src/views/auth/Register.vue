<template>
    <div class="card">
        <div class="card-body">
            <h1 class="card-title h4 mb-3" v-t="'title.register'"></h1>

            <app-form @submit="register" ref="form">
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

                <form-group name="terms" :has-label="false">
                    <div class="form-check" slot-scope="{bindings, id}">
                        <input type="checkbox"
                               class="form-check-input"
                               v-bind="bindings"
                               v-validate="'required'"
                               v-model="form.terms">
                        <label class="form-check-label" :for="id" v-html="$t('form.termsOfService', [terms])"></label>
                    </div>
                </form-group>

                <template slot="actions">
                    <app-button :label="$t('action.register')"
                                :busy="loading">
                    </app-button>
                </template>
            </app-form>
        </div>
    </div>
</template>

<script>
    import {termsUrl} from '../../config'
    import PasswordInput from '../../components/form/PasswordInput'

    export default {
        components: {
            PasswordInput
        },
        data() {
            return {
                form: {
                    email: '',
                    password: '',
                    terms: false
                },
                loading: false
            }
        },
        computed: {
            terms() {
                return termsUrl
            }
        },
        methods: {
            register() {
                this.loading = true
                this.$auth.register({
                    params: {
                        email: this.form.email,
                        password: this.form.password,
                        terms: this.form.terms
                    },
                    success: function () {
                        this.loading = false
                        this.$ga.event('Register', 'submit')
                    },
                    error: function (error) {
                        this.loading = false
                        this.$refs.form.error(error)
                    },
                    autoLogin: true,
                    rememberMe: true,
                    redirect: {name: 'budget_default'}
                })
            }
        }
    }
</script>
