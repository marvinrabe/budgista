<template>
    <input class="form-control"
           type="tel"
           ref="input"
           v-bind:step="step"
           v-on:focus="selectAll"
           v-on:keyup.enter="updateValue($event.target.value); $event.target.blur()"
           v-on:blur="updateValue($event.target.value)" />
</template>

<script>
    export default {
        props: {
            value: {
                type: Number,
                default: 0
            }
        },
        mounted: function () {
            this.formatValue(this.value * this.step)
        },
        watch: {
            value: function (newValue) {
                this.formatValue(newValue * this.step)
            }
        },
        computed: {
            step: function () {
                let currency = this.$store.state.currency;
                let locale = this.$store.state.locale;

                let formatter = Intl.NumberFormat(locale, {style: 'currency', currency: currency});
                return Math.pow(10, -1 * formatter.resolvedOptions().minimumFractionDigits);
            }
        },
        methods: {
            format: function (number) {
                let currency = this.$store.state.currency;
                let locale = this.$store.state.locale;

                let formatter = Intl.NumberFormat(locale, {style: 'currency', currency: currency});

                return formatter.format(number);
            },
            unformat: function (number) {
                let result = number;

                // remove thousand seperator
                let thousandSeparatorResults = this.format(12345.6).match(/12(.*)345/);
                if (thousandSeparatorResults.length) {
                    let thousandSeparator = thousandSeparatorResults[1];
                    result = result.replace(thousandSeparator, '')
                }

                // remove non-numeric signs except -> , .
                result = result.replace(/[^\d.,-]/g, '');

                // remove decimal seperator
                let decimalSeparatorResults = this.format(12345.6).match(/345(.*)6/);
                if (decimalSeparatorResults.length) {
                    let decimalSeparator = decimalSeparatorResults[1];
                    result = result.replace(decimalSeparator, '.');
                }

                // return real number
                return result;
            },
            updateValue: function (value) {
                let result = this.unformat(value);
                this.$emit('update:value', Math.round(result / this.step));
                this.formatValue(result);
            },
            formatValue: function (value) {
                this.$refs.input.value = this.format(value);
            },
            selectAll: function (event) {
                setTimeout(function () {
                    event.target.select()
                }, 0)
            }
        }
    }
</script>