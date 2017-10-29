<template>
    <span>{{ formattedValue }}</span>
</template>

<script>
    export default {
        props: ['value'],
        computed: {
            formattedValue: function () {
                return this.$formatMoney(this.value);
            }
        }
    }
</script>