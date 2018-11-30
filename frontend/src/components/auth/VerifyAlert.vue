<template>
    <div class="alert alert-warning" v-if="notVerified">
        <div class="d-md-flex align-items-center">
            <i18n path="message.verifyEmail" tag="div">
                <strong place="email">{{ email }}</strong>
            </i18n>
            <div class="mt-2 mt-md-0 ml-auto text-right">
                <div class="btn-group btn-group-sm">
                    <resend-verification></resend-verification>
                    <router-link class="btn btn-link d-none d-md-inline-block"
                                 :to="{name: 'profile'}"
                                 v-t="'action.changeEmail'">
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    @import '../../sass/_variables.scss';

    .btn-link {
        color: $black;
    }
</style>

<script>
    import ResendVerification from '../profile/ResendVerification'

    export default {
        components: {
            ResendVerification
        },
        computed: {
            email() {
                return this.$store.state.user.email
            },
            notVerified() {
                return !this.$store.state.user.verified
            }
        }
    }
</script>
