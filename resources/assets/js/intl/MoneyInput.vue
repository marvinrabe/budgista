<template>
    <input class="form-control"
           type="text"
           @focus="selectAll"
           @keyup.enter="updateValue($event.target.value)"
           @blur="updateValue($event.target.value)"/>
</template>

<script>
    import IntegerMoneyFormatter from './IntegerMoneyFormatter';

    export default {
        props: {
            value: {
                type: Number,
                default: 0
            }
        },
        mounted: function () {
            this.formatValue(this.value)
        },
        watch: {
            value: function (newValue) {
                this.formatValue(newValue)
            }
        },
        computed: {
            formatter() {
                return new IntegerMoneyFormatter(this.$store.state.locale, this.$store.state.currency);
            }
        },
        methods: {
            unformatValue: function (value) {
                return this.formatter.unformat(value);
            },
            updateValue: function (value) {
                let result = this.unformatValue(value);
                this.$emit('update:value', result);
                this.formatValue(result);
            },
            formatValue: function (value) {
                this.$el.value = this.formatter.format(value);
            },
            selectAll: function (event) {
                setTimeout(function () {
                    event.target.select()
                }, 0)
            }
        }
    }
</script>