<template>
    <div class="content container-fluid d-flex flex-column justify-content-center">
        <div class="my-4 text-center">
            <h5 v-t="'title.emptyAccount'"></h5>
            <div class="mt-2">
                <p class="m-0">
                    <span v-t="'messages.addTransactionBefore'"></span>
                    <span class="text-smaller text-light bg-primary p-1 rounded-circle" style="vertical-align: middle">
                        <font-awesome-icon :icon="icon" fixed-width></font-awesome-icon>
                    </span>
                    <span v-t="'messages.addTransactionAfter'"></span>
                </p>
                <p class="my-2 small d-none" style="font-weight: 300;">- OR -</p>
                <p class="m-0 d-none">Tell us your current account balance</p>
            </div>
        </div>
    </div>
</template>

<script>
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faPlus from '@fortawesome/fontawesome-free-solid/faPlus'

    export default {
        props: {
            account: {
                type: Object
            }
        },
        components: {
            FontAwesomeIcon
        },
        computed: {
            icon() {
                return faPlus;
            }

        }
    }
</script>