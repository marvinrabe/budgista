<template>
  <div class="flex items-center">
    <div class="flex mr-2">
      <inertia-link
        :title="$t('action.previousMonth')"
        :href="prev"
        class="btn btn--icon"
      >
        <font-awesome-icon :icon="previousIcon"/>
      </inertia-link>
      <inertia-link
        :title="$t('action.nextMonth')"
        :href="next"
        class="btn btn--icon"
      >
        <font-awesome-icon :icon="nextIcon"/>
      </inertia-link>
    </div>
    <span class="text-2xl mx-1">
      {{ month.format() }}
    </span>
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
