<template>
  <div class="d-flex">
    <router-link
      :title="$t('action.previousMonth')"
      :to="{ name: 'budget.month', params: {month: month.previous().toString()} }"
      class="text-dark align-self-center small"
    >
      <font-awesome-icon :icon="previousIcon"/>
    </router-link>
    <span class="mx-1">
      {{ month.format() }}
    </span>
    <router-link
      :title="$t('action.nextMonth')"
      :to="{ name: 'budget.month', params: {month: month.next().toString()} }"
      class="text-dark align-self-center small"
    >
      <font-awesome-icon :icon="nextIcon"/>
    </router-link>
  </div>
</template>

<script>
  import { faChevronLeft, faChevronRight } from '@fortawesome/free-solid-svg-icons'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  import Month from '../../models/Month'

  export default {
    components: {
      FontAwesomeIcon
    },
    props: {
      month: {
        type: Month,
        required: true
      }
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
