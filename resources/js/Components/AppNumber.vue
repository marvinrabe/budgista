<script>
  import AppMoney from './AppMoney'

  export default {
    functional: true,
    props: {
      value: Number,
      label: String,
      color: Boolean,
    },
    render (createElement, context) {
      return createElement('div', { class: 'numeric' }, [
        createElement(AppMoney, {
          props: {
            value: context.props.value,
            color: context.props.color
          },
          class: 'numeric__value'
        }),
        createElement('p', { staticClass: 'numeric__label' }, [context.props.label])
      ])
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../sass/_variables.scss";

  .numeric {
    padding: 0 1em;
    display: flex;
    flex: 1;
    flex-direction: column;
    align-items: flex-end;
    border-right: 1px solid $gray-300;

    &__label,
    &__value {
      flex: 1;
      flex-grow: 0;
      font-size: 1em;
      white-space: nowrap;
    }

    &__value {
      font-weight: 500;
    }

    &__label {
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
