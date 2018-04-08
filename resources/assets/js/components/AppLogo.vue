<template>
    <img src="../../images/logo.svg" :height="height" :alt="$t('app.name')">
</template>

<script>
    export default {
        props: {
            height: {
                type: Number,
                default: 48
            }
        }
    }
</script>