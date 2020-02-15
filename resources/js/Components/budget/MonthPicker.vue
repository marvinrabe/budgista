<template>
  <div class="flex items-center">
    <inertia-link
      :title="$t('action.previousMonth')"
      :href="prev"
      class="text-gray-6 hover:text-gray-8"
    >
      <font-awesome-icon :icon="previousIcon"/>
    </inertia-link>
    <span class="text-2xl mx-1">
      {{ month.format() }}
    </span>
    <inertia-link
      :title="$t('action.nextMonth')"
      :href="next"
      class="text-gray-6 hover:text-gray-8"
    >
      <font-awesome-icon :icon="nextIcon"/>
    </inertia-link>
  </div>
</template>

<script>
  import { faChevronLeft, faChevronRight } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import Month from '@/Utils/Month'

  export default {
    components: {
      FontAwesomeIcon
    },
    props: {
      month: Month,
      next: String,
      prev: String
    },
    computed: {
      previousIcon () {
        return faChevronLeft
      },
      nextIcon () {
        return faChevronRight
      }
    }
  }
</script>
