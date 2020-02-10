<script>
  import { fallbackLocale } from '../i18n'

  export default {
    props: {
      value: {
        type: String,
        required: true
      }
    },
    apollo: {
      me: {
        query: require('../gql/query/me.gql')
      }
    },
    computed: {
      locale () {
        if (!this.me) {
          return fallbackLocale
        }
        return this.me.locale
      },
      formatter () {
        return Intl.DateTimeFormat(this.locale, {
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
