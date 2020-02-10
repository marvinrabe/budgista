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
        type: Object,
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
          this.$router.push(this.to)
        }
        this.$emit('click')
      }
    }
  }
</script>

<style scoped>
  .btn {
    @apply mx-1 py-2 px-4 rounded bg-white border-gray-100 text-gray-600 bg-white cursor-pointer outline-none;
    transition: all 0.2s ease 0s;
  }

  .btn--small {
    @apply mx-1 py-1 px-2;
  }

  .btn:hover {
    @apply shadow text-black border-black;
  }

  .btn:active {
    @apply border-solid;
  }

  .btn--primary {
    @apply border-blue-600 text-white bg-blue-600;
  }

  .btn--subtle.btn--primary {
    @apply text-blue-600;
  }

  .btn--primary:hover {
    @apply bg-white text-blue-600 border-blue-600;
  }

  .btn--danger {
    @apply border-red-600 text-white bg-red-600;
  }

  .btn--subtle.btn--danger {
    @apply text-red-600;
  }

  .btn--danger:hover {
    @apply bg-white text-red-600 border-red-600;
  }

  .btn--subtle, .btn--subtle:hover, .btn--subtle:active {
    @apply shadow-none border-none bg-transparent;
  }
</style>
