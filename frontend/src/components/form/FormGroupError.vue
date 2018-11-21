<template>
    <span class="invalid-feedback" v-if="visible">
        {{ message }}
    </span>
</template>

<script>
    export default {
        props: {
            name: {
                type: String
            }
        },
        computed: {
            visible() {
                return this.errors.has(this.name)
            },
            message() {
                return this.errors.first(this.name)
            }
        }
    }
</script>

<style>
    /* Invalid Feedback is always displayed as block, because we use vue to hide message if there is no error. */
    .invalid-feedback {
        display: block;
    }
</style>
