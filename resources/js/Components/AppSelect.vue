<template>
  <div class="block relative">
    <select
      class="form-control"
      v-bind="$attrs"
      :value="value"
      @input="e => $emit('input', e.target.value)"
    >
      <slot/>
    </select>
    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-6">
      <SelectIcon class="h-4 w-4"/>
    </div>
  </div>
</template>

<script>
  import { faChevronDown } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '@/Utils/Icons'

  export default {
    inheritAttrs: false,
    props: ['value'],
    components: {
      SelectIcon: iconComponent({ icon: faChevronDown }),
    }
  }
</script>
