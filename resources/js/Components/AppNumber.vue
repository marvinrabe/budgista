<template>
  <div class="numeric">
    <AppMoney
      :value="value"
      :color="color"
      class="numeric__value"
    />
    <p class="numeric__label">
      {{ label }}
    </p>
  </div>
</template>

<script>
  import AppMoney from '@/Components/AppMoney'

  export default {
    components: { AppMoney },
    props: {
      value: Number,
      label: String,
      color: Boolean,
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
