<template>
  <div class="mb-4">
    <div class="flex items-center mb-2" v-if="hasLabel">
      <label
        v-t="labelTranslation"
        :for="name"
      />

      <slot name="additional" />
    </div>
    <slot
      :id="name"
      :bindings="bindings"
    />
    <span v-if="hasError" class="text-red-9 text-sm block">
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
