<template>
  <button
    :class="styling"
    :disabled="loading || disabled"
    :type="type"
    @click="click"
  >
    <AppSpinner v-if="loading"/>
    <slot v-else>
      {{ text }}
    </slot>
  </button>
</template>

<script>
  import AppSpinner from '../AppSpinner'

  export default {
    components: {
      AppSpinner
    },
    props: {
      label: {
        type: String,
        default: null
      },
      variant: {
        default: 'default',
        type: String
      },
      loading: {
        default: false,
        type: Boolean
      },
      disabled: {
        default: false,
        type: Boolean
      },
      small: {
        default: false,
        type: Boolean
      },
      subtle: {
        default: false,
        type: Boolean
      },
      to: {
        type: String,
        default: null
      }
    },
    computed: {
      icon () {
        return faSpinner
      },
      type () {
        return this.variant === 'primary' ? 'submit' : 'button'
      },
      styling () {
        let classes = ['btn']
        if (this.small) {
          classes.push('btn--small')
        }
        if (this.subtle) {
          classes.push('btn--subtle')
        }
        classes.push('btn--' + this.variant)
        return classes.join(' ')
      },
      text () {
        return this.label
      }
    },
    methods: {
      click () {
        if (this.disabled) {
          return
        }
        if (this.to) {
          this.$inertia.visit(this.to)
        }
        this.$emit('click')
      }
    }
  }
</script>
