<template>
    <button :class="styling"
            :disabled="busy || disabled">
        <font-awesome-icon :icon="icon" spin v-if="busy"/>
        {{ text }}
    </button>
</template>

<script>
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faSpinner from '@fortawesome/fontawesome-free-solid/faSpinner'

    export default {
        props: {
            label: {
                type: String
            },
            variant: {
                default: 'primary',
                type: String
            },
            busy: {
                default: false,
                type: Boolean
            },
            disabled: {
                default: false,
                type: Boolean
            }
        },
        components: {
            FontAwesomeIcon
        },
        computed: {
            icon() {
                return faSpinner
            },
            styling() {
                let classes = ['btn']
                classes.push('btn-' + this.variant)
                return classes.join(' ')
            },
            text() {
                return this.label
            }
        }
    }
</script>