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
    <FormGroupError :name="name" />
  </div>
</template>

<script>
  import FormGroupError from './FormGroupError'

  export default {
    components: {
      FormGroupError
    },
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
      }
    }
  }
</script>
