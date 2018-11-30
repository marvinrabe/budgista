<template>
    <input class="form-control"
           type="text"
           ref="input"
           :placeholder="placeholder"
           @focus="onFocus"
           @input="onInput($event.target.value)"
           @keyup.enter="onBlur($event.target.value)"
           @blur="onBlur($event.target.value)">
</template>

<script>
    export default {
        props: ['value'],
        data() {
            return {
                hasFocus: false,
                number: this.value
            }
        },
        computed: {
            placeholder() {
                return this.$moneyFormatter().format(0)
            }
        },
        mounted() {
            this.unprepareValue()
        },
        watch: {
            value() {
                if (!this.hasFocus) {
                    this.number = this.value;
                    this.unprepareValue()
                }
            }
        },
        methods: {
            formatValue(value) {
                return this.$moneyFormatter().format(value)
            },
            formatSimpleValue(value) {
                return this.$moneyFormatter().formatSimple(value)
            },
            unformatValue(value) {
                return this.$moneyFormatter().unformat(value)
            },
            prepareValue() {
                if (this.number !== 0) {
                    this.$el.value = this.formatSimpleValue(this.number)
                } else {
                    this.$el.value = ''
                }
            },
            unprepareValue() {
                if (this.number !== 0) {
                    this.$el.value = this.formatValue(this.number)
                } else {
                    this.$el.value = ''
                }
            },
            focus() {
                this.$refs.input.focus()
            },
            onFocus() {
                this.hasFocus = true
                this.prepareValue()
                this.selectAll(this.$el)
            },
            onInput(value) {
                this.number = this.unformatValue(value)
                this.$emit('input', this.number)
            },
            onBlur(value) {
                this.hasFocus = false
                this.$emit('change', this.number)
                this.onInput(value)
                this.unprepareValue()
            },
            selectAll() {
                let input = this.$el
                setTimeout(function () {
                    input.select()
                }, 0)
            }
        }
    }
</script>
