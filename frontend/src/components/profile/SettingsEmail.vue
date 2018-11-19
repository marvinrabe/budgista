<template>
    <app-form @submit="save" ref="form">

        <form-group name="currentEmail">
            <div class="form-text">
                {{ email }}
                <span class="badge badge-success" v-if="verified" v-t="'word.verified'"></span>
                <span class="badge badge-warning" v-else v-t="'word.unverified'"></span>
                <resend-verification class="btn-sm" v-if="!verified"></resend-verification>
            </div>
        </form-group>

        <form-group name="newEmail">
            <input type="email"
                   class="form-control"
                   slot-scope="{bindings}"
                   v-bind="bindings"
                   v-validate="'required|email'"
                   v-model="form.email">
        </form-group>

        <form-group name="password">
            <PasswordInput :disable-strength="true" slot-scope="group">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, group.bindings)"
                       v-on="handlers"
                       v-validate="'required'"
                       v-model="form.password">
            </PasswordInput>
        </form-group>

        <div slot="actions">
            <app-button :label="$t('action.settings.email')"
                        :busy="saving">
            </app-button>
        </div>
    </app-form>
</template>


<script>
    import ResendVerification from '../profile/ResendVerification'
    import PasswordInput from '@/components/form/PasswordInput'

    export default {
        components: {
            PasswordInput,
            ResendVerification
        },
        data() {
            return {
                saving: false,
                form: {
                    email: '',
                    password: ''
                }
            }
        },
        computed: {
            email() {
                return this.$store.state.user.email
            },
            verified() {
                return this.$store.state.user.verified
            }
        },
        mounted() {
            this.reset()
        },
        methods: {
            reset() {
                this.saving = false
                this.form.email = ''
                this.form.password = ''
            },
            save() {
                this.saving = true
                this.$store.dispatch('updateEmail', this.form)
                    .then(() => {
                        this.$snotify.success(this.$t('message.updateEmail'))
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false
                    })
            }
        }
    }
</script>
