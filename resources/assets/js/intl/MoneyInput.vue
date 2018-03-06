<template>
    <input class="form-control"
           type="text"
           @focus="selectAll"
           @keyup.enter="updateValue($event.target.value)"
           @blur="updateValue($event.target.value)"/>
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
            this.formatValue(this.value)
        },
        watch: {
            value: function (newValue) {
                this.formatValue(newValue)
            }
        },
        methods: {
            focus(value) {
                this.$el.focus();
                this.selectAll();
            },
            formatValue(value) {
                this.$el.value = this.$moneyFormatter().format(value);
            },
            unformatValue(value) {
                return this.$moneyFormatter().unformat(value);
            },
            updateValue(value) {
                let result = this.unformatValue(value);
                this.$emit('update:value', result);
                this.formatValue(result);
            },
            selectAll: function (event) {
                setTimeout(function () {
                    event.target.select()
                }, 0)
            }
        }
    }
</script>