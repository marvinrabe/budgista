<template>
  <input
    :placeholder="placeholder"
    inputmode="decimal"
    @blur="onBlur"
    @focus="onFocus"
    @input="onInput($event.target.value)"
    @keypress.enter="onEnter"
    class="form-input text-right"
    type="text"
  >
</template>

<script>
  import { mixin as moneyMixin } from '@/Utils/Money'

  export default {
    props: {
      value: {
        type: Number,
        default: null
      },
      allowNegative: {
        type: Boolean,
        default: false
      }
    },
    mixins: [moneyMixin],
    data () {
      return {
        hasFocus: false,
        number: this.value
      }
    },
    computed: {
      placeholder () {
        return this.moneyFormat.format(0)
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
          this.$el.value = this.moneyFormat.formatSimple(this.number)
        } else {
          this.$el.value = ''
        }
      },
      unprepareValue () {
        if (this.number !== 0) {
          this.$el.value = this.moneyFormat.format(this.number)
        } else {
          this.$el.value = ''
        }
      },
      focus () {
        this.$el.focus()
      },
      onFocus () {
        this.hasFocus = true
        this.prepareValue()
        this.selectAll(this.$el)
      },
      onInput (value) {
        this.number = this.moneyFormat.unformat(value, this.allowNegative)
        this.$emit('input', this.number)
      },
      onBlur () {
        this.hasFocus = false
        this.$emit('change', this.number)
        this.unprepareValue()
      },
      onEnter () {
        this.$el.blur()
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
