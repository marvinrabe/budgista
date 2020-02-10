<template>
  <span :title="text" class="small" v-if="value">
    <font-awesome-icon :icon="icon"/>
  </span>
</template>

<script>
  import { faSync } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

  export default {
    components: {
      FontAwesomeIcon
    },
    props: {
      value: {
        type: Object,
        default: null
      }
    },
    computed: {
      text () {
        return this.$tc('recurrence.' + this.value.frequency, this.value.interval)
      },
      icon () {
        return faSync
      }
    }
  }
</script>
