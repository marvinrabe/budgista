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
  import { formatter } from '@/helpers'

  export default {
    props: ['value'],
    data () {
      return {
        hasFocus: false,
        number: this.value
      }
    },
    computed: {
      placeholder () {
        return formatter.format(0)
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
      prepareValue () {
        if (this.number !== 0) {
          this.$el.value = formatter.formatSimple(this.number)
        } else {
          this.$el.value = ''
        }
      },
      unprepareValue () {
        if (this.number !== 0) {
          this.$el.value = formatter.format(this.number)
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
        this.number = formatter.unformat(value)
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
