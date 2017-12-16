<template>
    <span>{{ formattedValue }}</span>
</template>

<script>
    import IntegerMoneyFormatter from './IntegerMoneyFormatter';

    export default {
        props: ['value'],
        computed: {
            formattedValue: function () {
                return this.$formatMoney(this.value);
            }
        }
    }
</script>