<template>
    <span>{{ formattedValue }}</span>
</template>

<script>
    export default {
        props: ['value'],
        computed: {
            formattedValue: function () {
                let currency = this.$store.state.currency;
                let locale = this.$store.state.locale;

                let formatter = Intl.NumberFormat(locale, {style: 'currency', currency: currency});
                let decimalPlacesCorrection = Math.pow(10, -1*formatter.resolvedOptions().minimumFractionDigits);

                return formatter.format(this.value * decimalPlacesCorrection);
            }
        }
    }
</script>