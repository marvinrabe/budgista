<template>
  <input
    :placeholder="placeholder"
    @blur="onBlur($event.target.value)"
    @focus="onFocus"
    @input="onInput($event.target.value)"
    @keyup.enter="onBlur($event.target.value)"
    class="form-control"
    ref="input"
    type="text"
  >
</template>

<script>
  import moneyFormat from '../../mixins/moneyFormat'

  export default {
    mixins: [moneyFormat],
    props: ['value'],
    data () {
      return {
        hasFocus: false,
        number: this.value
      }
    },
    computed: {
      placeholder () {
        return this.moneyFormat(0)
      }
    },
    watch: {
      value () {
        if (!this.hasFocus) {
          this.number = this.value
          this.unprepareValue()
        }
      }
    },
    mounted () {
      this.unprepareValue()
    },
    methods: {
      formatValue (value) {
        return this.moneyFormat(value)
      },
      formatSimpleValue (value) {
        return this.moneyFormatter.formatSimple(value)
      },
      unformatValue (value) {
        return this.moneyFormatter.unformat(value)
      },
      prepareValue () {
        if (this.number !== 0) {
          this.$el.value = this.formatSimpleValue(this.number)
        } else {
          this.$el.value = ''
        }
      },
      unprepareValue () {
        if (this.number !== 0) {
          this.$el.value = this.formatValue(this.number)
        } else {
          this.$el.value = ''
        }
      },
      focus () {
        this.$refs.input.focus()
      },
      onFocus () {
        this.hasFocus = true
        this.prepareValue()
        this.selectAll(this.$el)
      },
      onInput (value) {
        this.number = this.unformatValue(value)
        this.$emit('input', this.number)
      },
      onBlur (value) {
        this.hasFocus = false
        this.$emit('change', this.number)
        this.onInput(value)
        this.unprepareValue()
      },
      selectAll () {
        let input = this.$el
        setTimeout(function () {
          input.select()
        }, 0)
      }
    }
  }
</script>
