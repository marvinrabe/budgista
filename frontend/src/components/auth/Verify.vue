<template>
    <div class="card">
        <div class="card-body">

            <div class="text-center p-5" style="min-height: 230px;" v-if="loading">
                <app-spinner></app-spinner>
            </div>
            <div class="verify" v-else>
                <font-awesome-icon :icon="icon" size="5x"></font-awesome-icon>

                <h1 v-t="title"></h1>
                <p v-t="message"></p>

                <router-link to="/" class="btn btn-dark" v-t="'action.returnToApp'"></router-link>
            </div>

        </div>
    </div>
</template>

<style lang="scss" scoped>
    @import '../../sass/_variables.scss';

    .verify {
        text-align: center;

        svg {
            margin-bottom: .2em;
        }

        .fa {
            &-exclamation-circle {
                color: $yellow;
            }

            &-check-circle {
                color: $green;
            }
        }
    }
</style>

<script>
    import axios from 'axios'
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
    import {faExclamationCircle, faCheckCircle} from '@fortawesome/free-solid-svg-icons'
    import AppSpinner from '../AppSpinner'

    export default {
        props: ['token'],
        components: {
            AppSpinner,
            FontAwesomeIcon
        },
        data() {
            return {
                loading: true,
                verified: false
            }
        },
        computed: {
            icon() {
                if (this.verified) {
                    return faCheckCircle
                }
                return faExclamationCircle
            },
            title() {
                if (this.verified) {
                    return 'title.success'
                }
                return 'title.error'
            },
            message() {
                if (this.verified) {
                    return 'message.verificationSuccessful'
                }
                return 'message.verificationFailed'
            }
        },
        created() {
            return new axios.put('/auth/verify/' + this.token)
                .then(() => {
                    this.verified = true
                })
                .finally(() => {
                    this.loading = false
                })
        }
    }
</script>
