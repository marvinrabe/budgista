<template>
    <app-form @submit="save" ref="form">

        <div class="form-row align-items-baseline">
            <div class="col-lg-4">
                <h2 class="h5" v-t="'title.updatePassword'"></h2>
            </div>
            <div class="col-lg-4">
                <form-group label="oldPassword" name="password">
                    <PasswordInput
                            :disable-strength="true"
                            v-model="form.password"
                    />
                </form-group>
            </div>
            <div class="col-lg-4">
                <form-group name="newPassword">
                    <PasswordInput
                            slot-scope="{bindings}"
                            v-bind="bindings"
                            v-model="form.new_password"
                            validation="required|min:6"
                    />
                </form-group>
            </div>
        </div>

        <div slot="actions">
            <app-button :busy="saving"
                        :label="$t('action.settings.password')">
            </app-button>
        </div>
    </app-form>
</template>

<script>
    import PasswordInput from '@/components/form/PasswordInput'

    export default {
        components: {
            PasswordInput
        },
        data() {
            return {
                saving: false,
                form: {
                    password: '',
                    new_password: ''
                }
            }
        },
        mounted() {
            this.reset()
        },
        methods: {
            reset() {
                this.saving = false
                this.form.password = ''
                this.form.new_password = ''
            },
            save() {
                this.saving = true
                this.$store.dispatch('updatePassword', this.form)
                    .then(() => {
                        this.$snotify.success(this.$t('message.updatePassword'))
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false
                    })
            }
        }
    }
</script>
