<script>
  export default {
    functional: true,
    props: {
      loading: {
        type: Boolean,
        default: false
      },
      width: {
        type: String,
        default: '66%'
      },
      height: {
        type: String,
        default: '1em'
      },
      margin: {
        type: String,
        default: '0.25em'
      }
    },
    render (createElement, context) {
      if (!context.props.loading) {
        return context.slots().default
      }

      return createElement('div', {
        style: {
          height: context.props.height,
          width: context.props.width,
          backgroundColor: 'rgba(0, 0, 0, 0.1)',
          margin: context.props.margin,
          animationDuration: '1s'
        },
        class: ['tb-skeleton', 'c-skeleton__tb--opacity', 'c-skeleton__tb--radius']
      })
    }
  }
</script>
