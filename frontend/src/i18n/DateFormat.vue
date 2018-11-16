<template>
    <span style="white-space: nowrap;">{{ formattedValue }}</span>
</template>
<script>
    // {year: 'numeric', month: '2-digit', day: '2-digit'}
    export default {
        props: ['value', 'options'],
        computed: {
            formattedValue: function () {
                let locale = this.$store.state.locale;
                let date = new Date(this.value);

                return this.$d(date, 'short', this.$store.state.locale);
                //return Intl.DateTimeFormat(locale, this.options).format(date);
            }
        }
    }
</script>