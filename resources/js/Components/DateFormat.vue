<script>
  import dayjs from 'dayjs'

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
      const rawDate = dayjs(this.value).format('YYYY-MM-DD')
      const date = new Date(rawDate)

      return this._v(this.formatter.format(date))
    }
  }
</script>
