<template>
    <select
      class="form-select"
      :value="value"
      @input="select"
    >
      <slot/>
    </select>
</template>

<script>
  import { faChevronDown } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '@/Utils/Icons'

  export default {
    props: ['value'],
    components: {
      SelectIcon: iconComponent({ icon: faChevronDown }),
    },
    methods: {
      select (event) {
        this.$emit('input', event.target.value)
      }
    }
  }
</script>
