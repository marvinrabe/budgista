export default {
  props: {
    title: String
  },
  title: {
    immediate: true,
    handler (title) {
      document.title = title ? `${title} | Budgista` : 'Budgista'
    }
  }
}
