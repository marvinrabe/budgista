<script>
  export default {
    props: {
      value: {
        type: String,
        required: true
      }
    },
    computed: {
      formatter () {
        return Intl.DateTimeFormat(this.$page.user.locale, {
          year: 'numeric',
          month: '2-digit',
          day: '2-digit'
        })
      }
    },
    render () {
      const date = new Date(this.value)

      return this._v(this.formatter.format(date))
    }
  }
</script>
