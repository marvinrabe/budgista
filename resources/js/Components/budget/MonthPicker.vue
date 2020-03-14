<template>
  <div class="flex items-center">
    <h2 class="text-xl">
      {{ month.format() }}
    </h2>
    <div class="flex">
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
  </div>
</template>

<script>
  import { faChevronLeft, faChevronRight } from '@fortawesome/free-solid-svg-icons'
  import Month from '@/Utils/Month'
  import { iconComponent } from '@/Utils/Icons'

  export default {
    components: {
      NextIcon: iconComponent({ icon: faChevronRight, fixedWidth: true }),
      PrevIcon: iconComponent({ icon: faChevronLeft, fixedWidth: true })
    },
    props: {
      month: Month,
      next: String,
      prev: String
    }
  }
</script>
