<template>
  <div class="offline">
    <font-awesome-layers class="offline__icon fa-lg">
      <font-awesome-icon :icon="slashIcon" :mask="cloudIcon" transform="down-1.5"/>
      <font-awesome-icon :icon="slashIcon"/>
    </font-awesome-layers>

    <h2 class="offline__title">No Internet</h2>

    <AppButton @click="$emit('retry')" label="Retry"/>
  </div>
</template>

<script>
  import { faCloud, faSlash } from '@fortawesome/free-solid-svg-icons'
  import AppButton from './form/AppButton'
  import { FontAwesomeIcon, FontAwesomeLayers } from '@fortawesome/vue-fontawesome'

  export default {
    components: {
      AppButton,
      FontAwesomeIcon,
      FontAwesomeLayers
    },
    computed: {
      cloudIcon () {
        return faCloud
      },
      slashIcon () {
        return faSlash
      }
    }
  }
</script>

<style scoped>
  .offline {
    @apply text-center text-grey py-24;
  }

  .offline__title {
    @apply text-2xl mt-1 mb-8;
  }
</style>
