<template>
    <span v-if="rrule" :title="text">
        <font-awesome-icon :icon="icon"/>
    </span>
</template>

<script>
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faSync from '@fortawesome/fontawesome-free-solid/faSync'
    import {rrulestr} from 'rrule';

    export default {
        props: {
            rrule: {
                type: String
            }
        },
        components: {
            FontAwesomeIcon
        },
        computed: {
            text() {
                return rrulestr(this.rrule).toText();
            },
            icon() {
                return faSync;
            }
        }
    }
</script>