export default {
  props: {
    title: String
  },
  watch: {
    title: {
      immediate: true,
      handler (title) {
        document.title = title ? `${title} | Budgista` : 'Budgista'
      }
    },
  },
  mounted () {
    if (window.gtag) {
      window.gtag('config', 'UA-1348458-29', {
        'anonymize_ip': true,
        'allow_ad_personalization_signals': false,
        'page_path': this.$inertia.page.url
      })
    }
  },
}
