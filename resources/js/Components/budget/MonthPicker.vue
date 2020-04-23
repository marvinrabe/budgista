<template>
  <div class="flex items-center">
    <MonthPickerDropdown :value="value" @input="(m) => $emit('input', m)">
      <div class="btn btn--subtle light font-semibold text-xl">
        {{ value.format() }}
      </div>
    </MonthPickerDropdown>
    <div class="flex">
      <AppButton
        :title="$t('action.previousMonth')"
        @click="prev"
        icon>
        <PrevIcon/>
      </AppButton>
      <AppButton
        :title="$t('action.nextMonth')"
        @click="next"
        icon>
        <NextIcon/>
      </AppButton>
    </div>
  </div>
</template>

<script>
  import { faChevronLeft, faChevronRight } from '@fortawesome/free-solid-svg-icons'
  import Month from '@/Utils/Month'
  import { iconComponent } from '@/Utils/Icons'
  import AppButton from '@/Components/form/AppButton'
  import MonthPickerDropdown from '@/Components/budget/MonthPickerDropdown'

  export default {
    components: {
      MonthPickerDropdown,
      AppButton,
      NextIcon: iconComponent({ icon: faChevronRight }),
      PrevIcon: iconComponent({ icon: faChevronLeft })
    },
    props: {
      value: Month
    },
    methods: {
      next () {
        this.$emit('input', this.value.next())
      },
      prev () {
        this.$emit('input', this.value.previous())
      }
    }
  }
</script>
