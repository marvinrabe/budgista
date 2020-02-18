<template>
  <div class="flex items-center" v-if="paginator.last_page !== 1">
    <span class="text-gray-7">
      {{ $t('pagination.info', { from, to, total }) }}
    </span>
    <AppButton
      :title="$t('pagination.previous')"
      :to="paginator.prev_page_url"
      :disabled="!paginator.prev_page_url"
      icon
    >
      <PrevIcon/>
    </AppButton>
    <AppButton
      :title="$t('pagination.next')"
      :to="paginator.next_page_url"
      :disabled="!paginator.next_page_url"
      icon
    >
      <NextIcon/>
    </AppButton>
  </div>
</template>

<script>
  import { faChevronLeft, faChevronRight } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '@/Utils/Icons'
  import AppButton from '@/Components/form/AppButton'

  export default {
    components: {
      AppButton,
      NextIcon: iconComponent({ icon: faChevronRight, fixedWidth: true }),
      PrevIcon: iconComponent({ icon: faChevronLeft, fixedWidth: true })
    },
    props: {
      paginator: Object
    },
    computed: {
      from () {
        return (this.paginator.current_page - 1) * this.paginator.per_page + 1
      },
      to () {
        let result = this.paginator.current_page * this.paginator.per_page
        if (result > this.paginator.total) {
          return this.paginator.total
        }
        return result
      },
      total () {
        return this.paginator.total
      }
    }
  }
</script>
