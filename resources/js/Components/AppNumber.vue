<script>
  import AppMoney from './AppMoney'
  import AppSkeleton from './AppSkeleton'

  export default {
    functional: true,
    components: {
      AppMoney,
      AppSkeleton
    },
    props: {
      value: Number,
      label: String,
      color: Boolean,
      loading: Boolean
    },
    render (createElement, context) {
      return createElement('div', { class: 'numeric' }, [
        createElement(AppSkeleton, { props: { loading: context.props.loading } }, [
          createElement(AppMoney, {
            props: {
              value: context.props.value,
              color: context.props.color
            },
            class: 'numeric-value'
          })
        ]),
        createElement('p', { staticClass: 'numeric-label' }, [context.props.label])
      ])
    }
  }
</script>

<style lang="scss" scoped>
  @import "../sass/_variables.scss";

  .numeric {
    padding: 0 1em;
    display: flex;
    flex: 1;
    flex-direction: column;
    align-items: flex-end;
    border-right: 1px solid $gray-300;

    &-label,
    &-value {
      flex: 1;
      flex-grow: 0;
      font-size: 1em;
      white-space: nowrap;
    }

    &-value {
      font-weight: 500;
    }

    &-label {
      font-size: .8em;
      color: $gray-600;
    }

    &:last-child {
      border-right: 0;
    }

    &:first-child {
      border-left: 0;
    }
  }
</style>
