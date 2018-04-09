<template>
    <div class="card">
        <div class="card-body">
            <h1 class="card-title h4 mb-3" v-t="'title.register'"></h1>

            <app-form @submit="register">
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
                    <app-password slot-scope="group">
                        <input class="form-control"
                               slot-scope="{bindings, handlers}"
                               v-bind="Object.assign(bindings, group.bindings)"
                               v-on="handlers"
                               v-validate.initial="'required'"
                               v-model="form.password">
                    </app-password>
                </form-group>

                <div class="form-group">
                    <div class="form-check">
                        <input id="terms"
                               type="checkbox"
                               class="form-check-input"
                               v-model="form.terms">
                        <label class="form-check-label" for="terms" v-html="$t('form.termsOfService', [terms])"></label>
                    </div>
                </div>

                <template slot="actions">
                    <app-button :label="$t('action.register')" :busy="loading"></app-button>
                </template>
            </app-form>
        </div>
    </div>
</template>

<script>
    import {termsUrl} from '../../config'

    export default {
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
                    },
                    error: function () {
                        this.loading = false
                    },
                    autoLogin: true,
                    rememberMe: true,
                    redirect: {name: 'budget_default'}
                })
            }
        }
    }
</script>