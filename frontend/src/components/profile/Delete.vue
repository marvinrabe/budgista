<template>
    <div class="main">
        <AppToolbar :title="$t('title.deleteUser')"/>

        <div class="card mb-3">
            <div class="card-body">
                <p v-t="'message.deleteUser'"></p>

                <app-form @submit="deleteUser" ref="form">

                    <form-group name="feedback">
                        <textarea class="form-control"
                                  slot-scope="{bindings}"
                                  v-bind="bindings"
                                  v-model="feedback">
                        </textarea>
                    </form-group>

                    <form-group name="password">
                        <PasswordInput
                                slot-scope="{bindings}"
                                v-bind="bindings"
                                v-model="password"
                                :disable-strength="true"
                        />
                    </form-group>

                    <div slot="actions">
                        <app-button :label="$t('action.deleteUser')"
                                    :busy="deleting"
                                    variant="danger"></app-button>
                    </div>
                </app-form>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios'
    import AppToolbar from '../AppToolbar'
    import PasswordInput from '@/components/form/PasswordInput'

    export default {
        components: {
            AppToolbar,
            PasswordInput
        },
        data() {
            return {
                feedback: '',
                password: '',
                deleting: false
            }
        },
        methods: {
            deleteUser() {
                this.deleting = true

                axios
                    .delete('/user', {
                        data: {
                            password: this.password,
                            feedback: this.feedback
                        }
                    })
                    .then(() => {
                        this.$snotify.success(this.$t('message.userDeleted'))
                        this.$auth.logout({
                            makeRequest: true,
                            success: function () {
                                this.$store.dispatch('RESET')
                            },
                            redirect: {name: 'login'}
                        })
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.deleting = false
                    })
            }
        }
    }
</script>
