<template>
  <button
    :class="styling"
    :disabled="loading || disabled"
    :type="buttonType"
    @click="click"
  >
    <slot>
      {{ text }}
    </slot>
  </button>
</template>

<script>
  export default {
    props: {
      label: {
        type: String,
        default: null
      },
      variant: {
        default: 'default',
        type: String
      },
      type: {
        default: 'button',
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
      icon: {
        default: false,
        type: Boolean
      },
      to: {
        type: String,
        default: null
      }
    },
    computed: {
      buttonType () {
        return this.variant === 'primary' ? 'submit' : this.type
      },
      styling () {
        let classes = ['btn']
        if (this.small) {
          classes.push('btn--small')
        }
        if (this.subtle) {
          classes.push('btn--subtle')
        }
        if (this.icon) {
          classes.push('btn--icon')
        }
        classes.push(this.variant)
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
