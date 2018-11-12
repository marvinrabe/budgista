<template>
    <div id="wrapper">
        <div class="error">
            <font-awesome-icon :icon="icon" size="5x"></font-awesome-icon>
            <h1 v-t="'title.pageNotFound'">Not Found</h1>
            <p v-t="'message.pageNotFound'">The requested page could not be found.</p>
            <router-link to="/" class="btn btn-dark" v-t="'action.returnToApp'"></router-link>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    @import '../../../sass/_variables.scss';

    #wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .error {
        text-align: center;

        svg {
            -webkit-animation: pulsate 2s ease-out;
            -webkit-animation-iteration-count: infinite;
            margin-bottom: .2em;
        }

        .fa {
            &-lock {
                color: $yellow;
            }

            &-exclamation-triangle {
                color: $red;
            }

            &-question-circle {
                color: $cyan;
            }
        }
    }

    @-webkit-keyframes pulsate {
        0% {
            opacity: 0.5
        }
        50% {
            opacity: 1.0
        }
        100% {
            opacity: 0.5
        }
    }

</style>

<script>
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
    import {faQuestionCircle} from '@fortawesome/free-solid-svg-icons'

    export default {
        components: {
            FontAwesomeIcon
        },
        computed: {
            icon() {
                return faQuestionCircle
            }
        }
    }
</script>
