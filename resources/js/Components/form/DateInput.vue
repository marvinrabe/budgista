<script>
  import Modernizr from 'modernizr'
  import DateInputFallback from './DateInputFallback'

  export default {
    props: {
      value: String
    },
    computed: {
      hasHTML5DateInput () {
        return Modernizr.inputtypes.date
      }
    },
    render (createElement) {
      if (this.hasHTML5DateInput) {
        return createElement('input', {
          'class': 'form-control',
          attrs: {
            type: 'date',
            value: this.value,
            ...this.$attrs
          },
          on: {
            input: e => this.$emit('input', e.target.value)
          },
          directives: [
            {
              name: 'validate',
              value: 'required'
            }
          ]
        })
      }

      return createElement(DateInputFallback, {
        props: {
          value: this.value
        },
        on: {
          input: e => this.$emit('input', e)
        }
      })
    }
  }
</script>
