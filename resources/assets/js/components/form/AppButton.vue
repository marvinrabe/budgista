<template>
    <button :class="styling"
            :disabled="busy">
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
            type: {
                default: 'primary',
                type: String
            },
            busy: {
                default: false,
                type: Boolean
            }
        },
        components: {
            FontAwesomeIcon
        },
        computed: {
            icon () {
                return faSpinner
            },
            styling() {
                let classes = ['btn'];
                switch (this.type) {
                    case 'primary':
                        classes.push('btn-primary');
                        break;
                    case 'secondary':
                        classes.push('btn-light');
                        break;
                    case 'tertiary':
                        classes.push('btn-text-dark');
                        break;
                }
                return classes.join(' ');
            },
            text() {
                return this.label;
            }
        }
    }
</script>