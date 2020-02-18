<template>
  <div class="flex items-center">
    <div class="flex mr-2">
      <inertia-link
        :title="$t('action.previousMonth')"
        :href="prev"
        class="btn btn--icon"
      >
        <PrevIcon />
      </inertia-link>
      <inertia-link
        :title="$t('action.nextMonth')"
        :href="next"
        class="btn btn--icon"
      >
        <NextIcon />
      </inertia-link>
    </div>
    <span class="text-2xl mx-1">
      {{ month.format() }}
    </span>
  </div>
</template>

<script>
  import { faChevronLeft, faChevronRight } from '@fortawesome/free-solid-svg-icons'
  import Month from '@/Utils/Month'
  import { iconComponent } from '@/helpers'

  export default {
    components: {
      NextIcon: iconComponent({ icon: faChevronRight, fixedWidth: true }),
      PrevIcon: iconComponent({ icon: faChevronRight, fixedWidth: true })
    },
    props: {
      month: Month,
      next: String,
      prev: String
    }
  }
</script>
