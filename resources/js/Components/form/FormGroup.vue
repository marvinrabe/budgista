<template>
  <div class="form-group">
    <label
      v-if="hasLabel"
      v-t="labelTranslation"
      :for="name"
    />
    <slot
      :id="name"
      :bindings="bindings"
    />
    <span v-if="hasError" class="invalid-feedback block">
      {{ errorMessage }}
    </span>
  </div>
</template>

<script>
  export default {
    props: {
      name: {
        type: String
      },
      label: {
        type: String,
        default: null
      },
      hasLabel: {
        type: Boolean,
        default: true
      }
    },
    computed: {
      labelTranslation () {
        return 'form.' + (this.label || this.name)
      },
      bindings () {
        return {
          id: this.name,
          name: this.name
        }
      },
      hasError () {
        return this.name in this.$page.errors
      },
      errorMessage () {
        return this.$page.errors[this.name][0]
      }
    }
  }
</script>
