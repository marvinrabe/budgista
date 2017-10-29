<template>
    <span>{{ formattedValue }}</span>
</template>

<script>
    export default {
        props: ['value', 'options'],
        computed: {
            formattedValue: function () {
                let locale = this.$store.state.locale;
                let date = new Date(this.value);

                return Intl.DateTimeFormat(locale, this.options).format(date);
            }
        }
    }
</script>