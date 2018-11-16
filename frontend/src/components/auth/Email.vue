<template>
    <div class="card">
        <div class="card-body">
            <h1 class="card-title h4 mb-3" v-t="'title.reset'"></h1>

            <app-form @submit="sendReset" ref="form">

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

                <template slot="actions">
                    <app-button :label="$t('action.sendReset')"
                                :busy="loading">
                    </app-button>
                </template>
            </app-form>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    email: ''
                },
                loading: false
            }
        },
        methods: {
            sendReset() {
                this.loading = true

                axios
                    .post('/auth/reset-password/', {
                        email: this.form.email
                    })
                    .then(() => {
                        this.$snotify.success(this.$t('message.resetPasswordEmailSent'))
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.loading = false
                    })
            }
        }
    }
</script>
