<template>
    <a href="#"
       :class="classes"
       @click.prevent="toggle"
       v-if="!transaction.isFuture()">
        <font-awesome-icon :icon="icon"/>
    </a>
</template>


<script>
    import Transaction from '../../models/Transaction'
    import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
    import {faCheckCircle} from '@fortawesome/free-solid-svg-icons'

    export default {
        props: {
            transaction: {
                type: Transaction,
                required: true
            }
        },
        components: {
            FontAwesomeIcon
        },
        computed: {
            icon() {
                return faCheckCircle
            },
            classes() {
                return this.transaction.cleared ? 'text-success' : 'text-darker-light'
            }
        },
        methods: {
            toggle() {
                this.$store.dispatch('transactions/clear', this.transaction)
            }
        }
    }
</script>
