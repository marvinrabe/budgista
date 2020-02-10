<template>
  <div class="d-flex border rounded p-1 flex-wrap">
    <div
      :class="{'bg-primary text-white': icon.name === value, 'text-dark': icon.name !== value}"
      :key="icon.name"
      @click="$emit('input', icon.name)"
      class="icon p-1 rounded"
      v-for="icon in icons"
    >
      <font-awesome-icon
        :icon="icon.icon"
        fixed-width
      />
    </div>
  </div>
</template>

<style scoped>
  .icon {
    cursor: pointer;
  }
</style>

<script>
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import accountIcons from './accountIcons'

  export default {
    components: {
      FontAwesomeIcon
    },
    props: {
      value: {
        type: String,
        required: true
      }
    },
    computed: {
      icons () {
        return accountIcons
      }
    }
  }
</script>
